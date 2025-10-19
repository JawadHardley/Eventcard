@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card bg-base-100 p-10 border-2 border-stone-700/10">
                {{-- <div id="reader" style="width: 320px; margin: auto; border-radius: 12px; overflow: hidden;"></div> --}}
                <div id="reader" class="mx-auto mt-5 w-full max-w-md border-2 border-dashed border-gray-300 rounded-lg">
                    <figure class="p-10 camera-icon">
                        <i class="fa fa-camera text-9xl inline"></i>
                    </figure>
                </div>
                <div class="card-body items-center text-center">
                    <p class="textqr">
                        If you already have your gestlist ready and accurate, fire the camera button and lets get scanning
                    </p>
                    <div class="card-actions pt-10">
                        <button id="startCamera" class="btn btn-outline btn-primary">
                            <i class="fa fa-qrcode"></i> Scan
                        </button>
                        <button id="flipCamera" class="btn btn-sm btn-primary">Flip Camera</button>
                        <button id="stopCamera" class="btn btn-secondary">
                            <i class="fa fa-stop"></i> Stop
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DaisyUI Modal -->
    <input type="checkbox" id="qrModal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="modalTitle">Verify Guest</h3>
            <p id="modalMessage" class="py-2">Guest Info</p>
            <div class="modal-action" id="modalActions">
                <button id="verifyBtn" class="btn btn-primary">Check-in</button>
                <label for="qrModal" class="btn btn-outline btn-error" id="closeModalBtn">Close</label>
            </div>
        </div>
    </div>


    {{-- <script type="module">
        const html5QrCode = new Html5Qrcode("reader");

        document.getElementById("startCamera").addEventListener("click", async () => {
            try {
                const cameras = await Html5Qrcode.getCameras();
                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id;

                    await html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        },
                        async (decodedText) => {
                                console.log("QR Detected:", decodedText);

                                // Call backend for verification
                                try {
                                    const response = await fetch(
                                        `/user/verify-qr?code=${encodeURIComponent(decodedText)}`);
                                    const data = await response.json();

                                    if (data.success) {
                                        alert(`✅ Verified: Good job`);
                                    } else {
                                        alert(`❌ Wrong QR man: ${data.message}`);
                                    }
                                } catch (err) {
                                    console.error("Verification error:", err);
                                }
                            },
                            (errorMsg) => console.warn("Scanning error:", errorMsg)
                    );
                } else {
                    alert("No camera found 😢");
                }
            } catch (err) {
                console.error("Camera error:", err);
                alert("Could not access camera 😢");
            }
        });

        document.getElementById("stopCamera").addEventListener("click", () => {
            html5QrCode.stop().then(() => {
                console.log("Camera stopped");
            }).catch(err => console.error("Stop failed", err));
        });
    </script> --}}

    {{-- <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;

        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const canvas = document.getElementById('id');

        const qrModalCheckbox = document.getElementById('qrModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const verifyBtn = document.getElementById('verifyBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Start camera
        startBtn.addEventListener("click", async () => {
            // Hide elements
            if (cameraIcon) cameraIcon.style.display = "none";
            if (textQr) textQr.style.display = "none";
            if (startBtn) startBtn.style.display = "none";
            if (stopBtn) stopBtn.style.display = "inline-block";
            if (canvas) canvas.classList.remove("hidden");

            try {
                const cameras = await Html5Qrcode.getCameras();
                if (!cameras || cameras.length === 0) return alert("No camera found 😢");

                const cameraId = cameras[0].id;
                // Detect if device is mobile
                // const isMobile = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);

                // if (isMobile) {
                //     // Try to find back/rear/environment camera
                //     const rearCamera = cameras.find(cam =>
                //         /back|rear|environment/i.test(cam.label)
                //     );
                //     if (rearCamera) cameraId = rearCamera.id;
                // }
                await html5QrCode.start(
                    cameraId, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    onQRCodeScanned,
                    errorMsg => {} // ignore NotFoundException spam
                );
            } catch (err) {
                console.error("Camera error:", err);
                alert("Could not access camera 😢");
            }
        });

        // Stop camera
        stopBtn.addEventListener("click", () => {
            html5QrCode.stop().then(() => {
                // Show elements back
                if (cameraIcon) cameraIcon.style.display = "";
                if (textQr) textQr.style.display = "";
                if (startBtn) startBtn.style.display = "";
                if (stopBtn) stopBtn.style.display = "none";
                if (canvas) canvas.classList.add("hidden");
                console.log("Camera stopped");
            }).catch(console.error);
        });

        // Hide stop button initially
        if (stopBtn) stopBtn.style.display = "none";

        // QR scanned
        async function onQRCodeScanned(decodedText) {
            // prevent double processing
            if (currentQR) return;

            currentQR = decodedText;

            try {
                // Pause safely
                try {
                    await html5QrCode.pause();
                } catch (e) {}

                // Fetch guest info from backend
                const response = await fetch(`/user/verify-qr?code=${encodeURIComponent(decodedText)}`);
                const data = await response.json();

                qrModalCheckbox.checked = true; // open modal

                if (data.success) {
                    modalTitle.textContent = "Guest Verified";
                    modalMessage.textContent = `Name: ${data.name}`;
                    verifyBtn.style.display = "inline-block"; // show attend button
                } else {
                    modalTitle.textContent = "QR Invalid";
                    modalMessage.innerHTML =
                        `<div class="badge badge-error">
                    <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><rect x="1.972" y="11" width="20.056" height="2" transform="translate(-4.971 12) rotate(-45)" fill="currentColor" stroke-width="0"></rect><path d="m12,23c-6.065,0-11-4.935-11-11S5.935,1,12,1s11,4.935,11,11-4.935,11-11,11Zm0-20C7.038,3,3,7.037,3,12s4.038,9,9,9,9-4.037,9-9S16.962,3,12,3Z" stroke-width="0" fill="currentColor"></path></g></svg>
                    Invalid
                    </div> Card does not for this event
                    `;
                    verifyBtn.style.display = "none"; // hide attend button
                }

            } catch (err) {
                modalTitle.textContent = "Error!";
                modalMessage.textContent = "Could not verify guest.";
                verifyBtn.style.display = "none";
                console.error(err);
            }
        }

        // Verify guest
        verifyBtn.addEventListener("click", async () => {
            if (!currentQR) return;

            try {
                const response = await fetch(`/user/verify-qr?code=${encodeURIComponent(currentQR)}&mark=1`);
                const data = await response.json();

                if (data.success) {
                    modalMessage.innerHTML =
                        `
                        <div class="badge badge-success">
                        <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle><polyline points="7 13 10 16 17 8" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></polyline></g></svg>
                        Checked In
                        </div> ${data.name}
                    `;
                } else {
                    modalMessage.innerHTML = `❌ Could not mark attended`;
                }
            } catch (err) {
                modalMessage.textContent = `❌ Error verifying guest`;
                console.error(err);
            }
        });

        // Resume scanning when modal closes
        closeModalBtn.addEventListener("click", async () => {
            currentQR = null;

            // Give modal a tiny delay to close fully
            setTimeout(async () => {
                try {
                    await html5QrCode.resume();
                } catch (err) {
                    console.log("Scanner resume ignored (probably already running)", err);
                }
            }, 50); // 50ms is enough for modal to close
        });
    </script> --}}

    <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;

        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera'); // you must create this button in HTML
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const canvas = document.getElementById('reader');

        // --- MODAL ELEMENTS ---
        const qrModalCheckbox = document.getElementById('qrModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const verifyBtn = document.getElementById('verifyBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // --- HIDE STOP AND FLIP INITIALLY ---
        stopBtn.style.display = "none";
        if (flipBtn) flipBtn.style.display = "none";

        // --- START CAMERA ---
        startBtn.addEventListener("click", async () => {
            if (cameraIcon) cameraIcon.style.display = "none";
            if (textQr) textQr.style.display = "none";
            startBtn.style.display = "none";
            stopBtn.style.display = "inline-block";
            if (flipBtn) flipBtn.style.display = "inline-block";
            canvas.classList.remove("hidden");

            try {
                allCameras = await Html5Qrcode.getCameras();
                if (!allCameras || allCameras.length === 0) {
                    alert("No camera found 😢");
                    return;
                }

                const isMobile = /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
                let selectedCamera;

                if (isMobile) {
                    // Prefer back camera
                    selectedCamera = allCameras.find(cam =>
                        /back|rear|environment/i.test(cam.label)
                    );
                    if (!selectedCamera) selectedCamera = allCameras[allCameras.length - 1];
                } else {
                    // Desktop — just use the first camera
                    selectedCamera = allCameras[0];
                }

                currentCameraId = selectedCamera.id;
                await startCamera(currentCameraId);
            } catch (err) {
                console.error("Camera error:", err);
                alert("Could not access camera 😢");
            }
        });

        async function startCamera(cameraId) {
            await html5QrCode.start(
                cameraId, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                onQRCodeScanned,
                () => {} // ignore errors
            );
            isRunning = true;
            console.log("Camera started:", cameraId);
        }

        // --- STOP CAMERA ---
        stopBtn.addEventListener("click", async () => {
            try {
                await html5QrCode.stop();
                isRunning = false;

                if (cameraIcon) cameraIcon.style.display = "";
                if (textQr) textQr.style.display = "";
                startBtn.style.display = "";
                stopBtn.style.display = "none";
                if (flipBtn) flipBtn.style.display = "none";
                canvas.classList.add("hidden");
                console.log("Camera stopped");
            } catch (err) {
                console.error("Error stopping camera:", err);
            }
        });

        // --- FLIP CAMERA BUTTON ---
        if (flipBtn) {
            flipBtn.addEventListener("click", async () => {
                if (!allCameras.length) return;
                try {
                    let nextIndex = allCameras.findIndex(c => c.id === currentCameraId) + 1;
                    if (nextIndex >= allCameras.length) nextIndex = 0;

                    const nextCamera = allCameras[nextIndex];
                    await html5QrCode.stop();
                    await startCamera(nextCamera.id);
                    currentCameraId = nextCamera.id;
                    console.log("Switched to camera:", nextCamera.label);
                } catch (err) {
                    console.error("Error flipping camera:", err);
                }
            });
        }

        // --- QR SCANNED ---
        async function onQRCodeScanned(decodedText) {
            if (currentQR) return;
            currentQR = decodedText;

            try {
                await html5QrCode.pause();

                const response = await fetch(`/user/verify-qr?code=${encodeURIComponent(decodedText)}`);
                const data = await response.json();

                qrModalCheckbox.checked = true;

                if (data.success) {
                    modalTitle.textContent = "Guest Verified";
                    modalMessage.textContent = `Name: ${data.name}`;
                    verifyBtn.style.display = "inline-block";
                } else {
                    modalTitle.textContent = "QR Invalid";
                    modalMessage.innerHTML = `
                    <div class="badge badge-error">❌ Invalid</div>
                    Card does not belong to this event
                `;
                    verifyBtn.style.display = "none";
                }
            } catch (err) {
                modalTitle.textContent = "Error!";
                modalMessage.textContent = "Could not verify guest.";
                verifyBtn.style.display = "none";
                console.error(err);
            }
        }

        // --- VERIFY GUEST ---
        verifyBtn.addEventListener("click", async () => {
            if (!currentQR) return;

            try {
                const response = await fetch(`/user/verify-qr?code=${encodeURIComponent(currentQR)}&mark=1`);
                const data = await response.json();

                if (data.success) {
                    modalMessage.innerHTML = `
                    <div class="badge badge-success">✅ Checked In</div> ${data.name}
                `;
                } else {
                    modalMessage.innerHTML = `❌ Could not mark attended`;
                }
            } catch (err) {
                modalMessage.textContent = `❌ Error verifying guest`;
                console.error(err);
            }
        });

        // --- RESUME AFTER MODAL CLOSE ---
        closeModalBtn.addEventListener("click", async () => {
            currentQR = null;
            setTimeout(async () => {
                try {
                    await html5QrCode.resume();
                } catch (err) {
                    console.log("Scanner resume ignored", err);
                }
            }, 100);
        });
    </script>
@endsection
