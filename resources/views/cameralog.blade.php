@extends('layouts.admin')

@section('title', 'QR Scanner')

@section('content')
    <div class="fade-up max-w-2xl mx-auto">
        <div class="card p-6 text-center">
            <div id="reader" class="hidden mx-auto w-full max-w-md border-2 border-dashed rounded-lg overflow-hidden">
            </div>
            <div class="camera-icon">
                <i class="fa fa-camera text-9xl inline text-gray-400"></i>
            </div>
            <p class="textqr mt-4 text-gray-500 dark:text-gray-400">
                If you already have your guest list ready, fire the camera button and start scanning.<br>
                <strong>Event: {{ $event->order_name }}</strong>
            </p>
            <div class="flex justify-center gap-3 mt-6">
                <button id="startCamera" class="btn btn-primary"><i class="fa fa-qrcode"></i> Scan</button>
                <button id="flipCamera" class="btn btn-secondary"><i class="fa fa-rotate"></i> Flip</button>
                <button id="stopCamera" class="btn btn-danger"><i class="fa fa-stop"></i> Stop</button>
            </div>
            <div class="divider my-6">OR</div>
            <div class="flex gap-2 justify-center">
                <input type="text" id="manualCode" placeholder="Invitation code" class="form-input w-40">
                <button id="manualVerifyBtn" class="btn btn-success">Manual Verify</button>
            </div>
        </div>
    </div>

    {{-- AuraUI Modals --}}
    <div id="modal-invalid" class="modal-overlay" onclick="handleModalClick(event, 'modal-invalid')">
        <div class="modal-box card p-6 text-center max-w-sm">
            <div class="text-6xl text-red-500 mb-4"><i class="fa fa-ban"></i></div>
            <h3 class="text-xl font-bold">Invalid QR</h3>
            <p id="invalidMessage" class="text-gray-500 mt-2">Card does not exist for this event.</p>
            <div class="mt-6"><button class="btn btn-secondary" onclick="closeModal('modal-invalid')">Close</button></div>
        </div>
    </div>

    <div id="modal-valid" class="modal-overlay" onclick="handleModalClick(event, 'modal-valid')">
        <div class="modal-box card p-6 text-center max-w-sm">
            <div class="text-6xl text-green-500 mb-4"><i class="fa fa-circle-check"></i></div>
            <h3 id="validTitle" class="text-xl font-bold">Valid Card</h3>
            <p id="validName" class="text-lg font-semibold mt-2">Guest Name</p>
            <div id="validBadgeContainer" class="mt-2 flex justify-center gap-2"></div>
            <div class="mt-6 flex gap-2 justify-center">
                <button id="validVerifyBtn" class="btn btn-primary">Check-in</button>
                <button class="btn btn-secondary" onclick="closeModal('modal-valid')">Close</button>
            </div>
        </div>
    </div>

    <div id="modal-used" class="modal-overlay" onclick="handleModalClick(event, 'modal-used')">
        <div class="modal-box card p-6 text-center max-w-sm">
            <div class="text-6xl text-yellow-500 mb-4"><i class="fa fa-check-double"></i></div>
            <h3 class="text-xl font-bold">Already Checked In</h3>
            <p id="usedName" class="text-gray-500 mt-2">Guest already attended</p>
            <div id="usedBadgeContainer" class="mt-2 flex justify-center gap-2"></div>
            <div class="mt-6"><button class="btn btn-secondary" onclick="closeModal('modal-used')">Close</button></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script type="module">
        let html5QrCode = null;
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;
        // Track whether the user had the camera active when a modal popped up,
        // so we know to auto-restart when they dismiss.
        let wasScanningBeforeModal = false;

        const eventId = @json($event->id);

        // DOM elements
        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera');
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const readerDiv = document.getElementById('reader');
        const manualVerifyBtn = document.getElementById('manualVerifyBtn');
        const manualCodeInput = document.getElementById('manualCode');

        // Modal elements
        const validVerifyBtn = document.getElementById('validVerifyBtn');
        const validNameSpan = document.getElementById('validName');
        const validTitle = document.getElementById('validTitle');
        const validBadgeContainer = document.getElementById('validBadgeContainer');
        const invalidMessageSpan = document.getElementById('invalidMessage');
        const usedNameSpan = document.getElementById('usedName');
        const usedBadgeContainer = document.getElementById('usedBadgeContainer');

        // Initial button states
        stopBtn.style.display = "none";
        if (flipBtn) flipBtn.style.display = "none";

        // ─── Scanner helpers ───────────────────────────────────────────

        async function stopScanner() {
            if (html5QrCode && isRunning) {
                try {
                    await html5QrCode.stop();
                } catch (err) {
                    console.warn("Error stopping scanner:", err);
                }
                isRunning = false;
            }
        }

        async function startCamera(cameraId) {
            // Always create a fresh instance — reusing a stopped instance causes the
            // "dashed box but no stream" problem.
            if (html5QrCode) {
                await stopScanner();
                try {
                    html5QrCode.clear();
                } catch (_) {}
                html5QrCode = null;
            }

            html5QrCode = new Html5Qrcode("reader");
            await html5QrCode.start(
                cameraId, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                onQRCodeScanned,
                () => {
                    /* suppress per-frame errors */ }
            );
            isRunning = true;
        }

        // Restore the full "camera active" UI state
        function showScanningUI() {
            if (cameraIcon) cameraIcon.style.display = "none";
            if (textQr) textQr.style.display = "none";
            startBtn.style.display = "none";
            stopBtn.style.display = "inline-block";
            if (flipBtn) flipBtn.style.display = "inline-block";
            readerDiv.classList.remove("hidden");
        }

        // Restore the idle/placeholder UI state
        function showIdleUI() {
            if (cameraIcon) cameraIcon.style.display = "";
            if (textQr) textQr.style.display = "";
            startBtn.style.display = "";
            stopBtn.style.display = "none";
            if (flipBtn) flipBtn.style.display = "none";
            readerDiv.classList.add("hidden");
        }

        // ─── Modal helpers ─────────────────────────────────────────────

        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        // Exposed globally so onclick="" attributes in the blade modals work
        window.closeModal = async function(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.remove('open');
            document.body.style.overflow = '';
            currentQR = null;

            // If the camera was active before the scan triggered this modal,
            // restart it automatically so the user can scan the next guest.
            if (wasScanningBeforeModal) {
                wasScanningBeforeModal = false;
                showScanningUI();
                try {
                    await startCamera(currentCameraId);
                } catch (err) {
                    console.error("Could not restart camera after modal:", err);
                    showToast("Could not restart camera. Tap Scan to retry.", "error");
                    showIdleUI();
                }
            }
        };

        window.handleModalClick = function(event, id) {
            if (event.target === document.getElementById(id)) closeModal(id);
        };

        // ─── Start Camera button ───────────────────────────────────────

        startBtn.addEventListener("click", async () => {
            showScanningUI();
            try {
                allCameras = await Html5Qrcode.getCameras();
                if (!allCameras || allCameras.length === 0) {
                    showToast("No camera found", "error");
                    showIdleUI();
                    return;
                }
                const isMobile = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
                let selected;
                if (isMobile) {
                    selected = allCameras.find(c => /back|rear|environment/i.test(c.label)) ||
                        allCameras[allCameras.length - 1];
                } else {
                    selected = allCameras[0];
                }
                currentCameraId = selected.id;
                await startCamera(currentCameraId);
            } catch (err) {
                console.error("Camera error:", err);
                showToast("Could not access camera", "error");
                showIdleUI();
            }
        });

        // ─── Stop Camera button ────────────────────────────────────────

        stopBtn.addEventListener("click", async () => {
            wasScanningBeforeModal = false; // user chose to stop, don't auto-restart
            await stopScanner();
            showIdleUI();
        });

        // ─── Flip Camera ───────────────────────────────────────────────

        if (flipBtn) {
            flipBtn.addEventListener("click", async () => {
                if (!allCameras.length) return;
                try {
                    let nextIndex = allCameras.findIndex(c => c.id === currentCameraId) + 1;
                    if (nextIndex >= allCameras.length) nextIndex = 0;
                    currentCameraId = allCameras[nextIndex].id;
                    await startCamera(currentCameraId);
                } catch (err) {
                    console.error("Error flipping camera:", err);
                    showToast("Could not flip camera", "error");
                }
            });
        }

        // ─── QR Scanned ────────────────────────────────────────────────

        async function onQRCodeScanned(decodedText) {
            if (currentQR) return; // already handling a scan
            currentQR = decodedText;

            // Remember that the camera WAS running so closeModal() can restart it
            wasScanningBeforeModal = true;

            // Stop scanner to prevent duplicate scans while modal is open
            await stopScanner();

            try {
                const response = await fetch(
                    `/user/verify-qr?code=${encodeURIComponent(decodedText)}&event_id=${eventId}`
                );
                const data = await response.json();

                if (data.status === "invalid") {
                    invalidMessageSpan.textContent = data.message || "Card does not exist for this event.";
                    openModal('modal-invalid');

                } else if (data.status === "valid") {
                    validNameSpan.textContent = data.name;
                    validTitle.textContent = "Valid Card";
                    const counterText = (data.type === 'double' && data.counter) ? ` ${data.counter}` : '';
                    validBadgeContainer.innerHTML = `
                        <span class="badge ${data.type === 'single' ? 'badge-blue' : 'badge-purple'}">${data.type}${counterText}</span>
                        <span class="badge badge-green">Not checked-in</span>
                    `;
                    validVerifyBtn.disabled = false;
                    validVerifyBtn.style.display = "";
                    validVerifyBtn.innerHTML = '<i class="fa fa-check"></i> Check-in';
                    validVerifyBtn.onclick = async () => {
                        validVerifyBtn.disabled = true;
                        validVerifyBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Checking...';
                        try {
                            const markRes = await fetch(
                                `/user/verify-card?code=${encodeURIComponent(decodedText)}&mark=1`);
                            const markData = await markRes.json();
                            if (markData.status === "checked_in") {
                                validTitle.textContent = "Checked In";
                                const markCounter = (markData.type === 'double' && markData.counter) ?
                                    ` ${markData.counter}` : '';
                                validBadgeContainer.innerHTML = `
                                    <span class="badge ${markData.type === 'single' ? 'badge-blue' : 'badge-purple'}">${markData.type}${markCounter}</span>
                                    <span class="badge badge-yellow">Used</span>
                                `;
                                validVerifyBtn.style.display = "none";
                                showToast(`${markData.name} checked in successfully`, "success");
                            } else {
                                validVerifyBtn.disabled = false;
                                validVerifyBtn.innerHTML = "Try Again";
                                showToast("Check-in failed", "error");
                            }
                        } catch (err) {
                            validVerifyBtn.disabled = false;
                            validVerifyBtn.innerHTML = "Retry";
                            showToast("Error marking check-in", "error");
                        }
                    };
                    openModal('modal-valid');

                } else if (data.status === "already_checked") {
                    usedNameSpan.textContent = data.name;
                    const usedCounter = (data.type === 'double' && data.counter) ? ` ${data.counter}` : '';
                    usedBadgeContainer.innerHTML = `
                        <span class="badge ${data.type === 'single' ? 'badge-blue' : 'badge-purple'}">${data.type}${usedCounter}</span>
                        <span class="badge badge-yellow">Already used</span>
                    `;
                    openModal('modal-used');

                } else {
                    invalidMessageSpan.textContent = "Unexpected response from server.";
                    openModal('modal-invalid');
                }
            } catch (err) {
                console.error("Error verifying:", err);
                invalidMessageSpan.textContent = "Error verifying card.";
                openModal('modal-invalid');
            }
        }

        // ─── Manual Verification ───────────────────────────────────────

        manualVerifyBtn.addEventListener('click', async () => {
            const code = manualCodeInput.value.trim();
            if (!code) {
                showToast("Enter a code", "error");
                return;
            }
            // Manual verify doesn't use the camera, so don't auto-restart after modal
            wasScanningBeforeModal = false;
            if (isRunning) await stopScanner();
            currentQR = code;

            try {
                const response = await fetch(
                    `/user/verify-qr?code=${encodeURIComponent(code)}&event_id=${eventId}`
                );
                const data = await response.json();

                if (data.status === "invalid") {
                    invalidMessageSpan.textContent = data.message || "Invalid code.";
                    openModal('modal-invalid');

                } else if (data.status === "valid") {
                    validNameSpan.textContent = data.name;
                    validTitle.textContent = "Valid Card";
                    const counterText = (data.type === 'double' && data.counter) ? ` ${data.counter}` : '';
                    validBadgeContainer.innerHTML = `
                        <span class="badge ${data.type === 'single' ? 'badge-blue' : 'badge-purple'}">${data.type}${counterText}</span>
                        <span class="badge badge-green">Not checked-in</span>
                    `;
                    validVerifyBtn.disabled = false;
                    validVerifyBtn.style.display = "";
                    validVerifyBtn.innerHTML = '<i class="fa fa-check"></i> Check-in';
                    validVerifyBtn.onclick = async () => {
                        validVerifyBtn.disabled = true;
                        validVerifyBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Checking...';
                        try {
                            const markRes = await fetch(
                                `/user/verify-card?code=${encodeURIComponent(code)}&mark=1`);
                            const markData = await markRes.json();
                            if (markData.status === "checked_in") {
                                validTitle.textContent = "Checked In";
                                validBadgeContainer.innerHTML =
                                    `<span class="badge badge-yellow">Used</span>`;
                                validVerifyBtn.style.display = "none";
                                showToast(`${markData.name} checked in`, "success");
                            } else {
                                validVerifyBtn.disabled = false;
                                validVerifyBtn.innerHTML = "Try Again";
                            }
                        } catch (err) {
                            validVerifyBtn.disabled = false;
                            validVerifyBtn.innerHTML = "Retry";
                        }
                    };
                    openModal('modal-valid');

                } else if (data.status === "already_checked") {
                    usedNameSpan.textContent = data.name;
                    usedBadgeContainer.innerHTML = `<span class="badge badge-yellow">Already used</span>`;
                    openModal('modal-used');
                }
            } catch (err) {
                showToast("Error verifying code", "error");
            }
        });

        // ─── Toast helper (local fallback in case global isn't ready) ──
        window.showToast = window.showToast || function(message, type) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML =
                `<span class="toast-msg">${message}</span><button onclick="this.closest('.toast').remove()">✕</button>`;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 10);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };
    </script>
@endsection
