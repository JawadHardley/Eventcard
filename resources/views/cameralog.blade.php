@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card bg-base-100 p-10 border-2 border-stone-700/10">
                {{-- <div id="reader" style="width: 320px; margin: auto; border-radius: 12px; overflow: hidden;"></div> --}}
                <div id="reader"
                    class="hidden mx-auto mt-5 w-full max-w-md border-2 border-dashed border-gray-300 rounded-lg">
                </div>
                <div class="card-body items-center text-center">
                    <p class="textqr">
                    <div class="p-10 camera-icon text-center">
                        <i class="fa fa-camera text-9xl inline"></i>
                    </div>
                    If you already have your gestlist ready and accurate, fire the camera button and lets get scanning
                    ({{ $event->id }})
                    </p>
                    <div class="card-actions pt-10">
                        <button id="startCamera" class="btn btn-outline btn-primary">
                            <i class="fa fa-qrcode"></i> Scan
                        </button>
                        <button id="flipCamera" class="btn btn-outline btn-primary rounded p-2">
                            <i class="fa fa-rotate mr-1"></i> Flip
                        </button>
                        <button id="stopCamera" class="btn btn-secondary rounded p-2">
                            <i class="fa fa-stop mr-1"></i> Stop
                        </button>
                    </div>
                    <div class="divider">OR</div>
                    <div class="my-2">
                        <input type="text" placeholder="****" class="input input-lg mb-4" />
                        <button id="startCamera" class="btn btn-outline btn-success my-2">
                            <i class="fa fa-circle-check"></i> Manual Verify
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
            <p id="qr_modal_message" class="py-2">Guest Info</p>
            <div class="modal-action" id="modalActions">
                <button id="verifyBtn" class="btn btn-primary">Check-in</button>
                <label for="qrModal" class="btn btn-outline btn-error" id="closeModalBtn">Close</label>
            </div>
        </div>
    </div>

    <!-- Open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_2.showModal()">open modal</button>
    <dialog id="my_modal_2" class="modal">
        <div class="modal-box border-2 border-rose-800/30">
            <h3 id="invalid_modal_title" class="text-2xl font-bold text-center mb-4">QR Invalid</h3>
            <h3 class="text-8xl text-center text-error">
                <i class="fa fa-ban"></i>
            </h3>
            <p id="invalid_modal_message" class="py-4 text-center">Card does not exist !!</p>
            <form method="dialog" class="text-center">
                <button class="btn btn-outline btn-error">close</button>
            </form>
        </div>
    </dialog>

    <!-- Open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_3.showModal()">open modal 3</button>
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box border-2 border-rose-800/30 flex items-center w-full flex-col">
            <h3 id="valid_modal_title" class="text-2xl font-bold text-center mb-4">Valid Card</h3>
            <h3 class="text-6xl text-center text-success">
                <i id="valid_modal_big_icon" class="fa fa-circle-check"></i>
            </h3>
            <p id="valid_modal_message" class="py-4 text-center text-xl fold-bold">James Maddison</p>
            <span class="mb-8" id="valid_badge_container">
                <div class="badge badge-soft badge-primary">Doublex</div>
                <div class="badge badge-soft badge-success">Not checked-in</div>
            </span>

            <div class="divider w-full"></div>
            <form method="dialog" class="text-center">
                <button id="valid_modal_verifyBtn" class="btn btn-success">
                    <i class="fa-solid fa-square-check mr-1"></i> Check-in
                </button>
                <button class="btn btn-outline btn-error">close</button>
            </form>
        </div>
    </dialog>

    <!-- Open the modal using ID.showModal() method -->
    <button class="btn" onclick="my_modal_4.showModal()">open modal 4</button>
    <dialog id="my_modal_4" class="modal">
        <div class="modal-box border-2 border-rose-800/30 flex items-center w-full flex-col">
            <h3 id="used_modal_title" class="text-2xl font-bold text-center mb-4">Valid Card</h3>
            <h3 class="text-6xl text-center text-accent">
                <i id="valid_modal_big_icon" class="fa fa-circle-check"></i>
            </h3>
            <p id="used_modal_message" class="py-4 text-center text-xl fold-bold">James Maddison</p>
            <span class="mb-8" id="used_badge_container">
                <div class="badge badge-soft badge-primary">Doubleyd</div>
                <div class="badge badge-soft badge-secondary">Used</div>
            </span>

            <div class="divider w-full"></div>
            <form method="dialog" class="text-center">
                <button class="btn btn-outline btn-error">close</button>
            </form>
        </div>
    </dialog>

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

    {{-- <script type="module">
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
    </script> --}}


    {{-- <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;

        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera');
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const canvas = document.getElementById('reader');

        // Modals
        const modalInvalid = document.getElementById("my_modal_2");
        const modalValid = document.getElementById("my_modal_3");
        const modalUsed = document.getElementById("my_modal_4");

        const verifyBtn = document.getElementById("verifyBtn");

        stopBtn.style.display = "none";
        if (flipBtn) flipBtn.style.display = "none";

        // START CAMERA
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
                    selectedCamera = allCameras.find(cam =>
                        /back|rear|environment/i.test(cam.label)
                    );
                    if (!selectedCamera) selectedCamera = allCameras[allCameras.length - 1];
                } else {
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
                () => {}
            );
            isRunning = true;
            console.log("Camera started:", cameraId);
        }

        // STOP CAMERA
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

        // FLIP CAMERA
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

                console.log("Response:", data);

                if (data.status === "invalid") {
                    modalInvalid.querySelector("#modalMessage").textContent = "Card does not exist !!";
                    modalInvalid.showModal();
                } else if (data.status === "valid") {
                    modalValid.querySelector("#modalMessage").textContent = data.name;
                    modalValid.showModal();

                    verifyBtn.onclick = async () => {
                        const markRes = await fetch(
                            `/user/verify-qr?code=${encodeURIComponent(currentQR)}&mark=1`);
                        const markData = await markRes.json();
                        modalValid.close();
                        if (markData.status === "checked_in") {
                            modalUsed.querySelector("#modalMessage").textContent = markData.name;
                            modalUsed.showModal();
                        }
                    };
                } else if (data.status === "already_checked") {
                    modalUsed.querySelector("#modalMessage").textContent = data.name;
                    modalUsed.showModal();
                }

            } catch (err) {
                console.error("Error verifying:", err);
                modalInvalid.querySelector("#modalMessage").textContent = "Error verifying card";
                modalInvalid.showModal();
            }
        }

        // Resume scanning when any modal closes
        document.querySelectorAll("dialog").forEach(modal => {
            modal.addEventListener("close", async () => {
                currentQR = null;
                setTimeout(async () => {
                    try {
                        await html5QrCode.resume();
                    } catch (err) {
                        console.log("Scanner resume ignored:", err);
                    }
                }, 100);
            });
        });
    </script> --}}

    {{-- <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;

        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera');
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const canvas = document.getElementById('reader');

        // Modals
        const modalInvalid = document.getElementById("my_modal_2");
        const modalValid = document.getElementById("my_modal_3");
        const modalUsed = document.getElementById("my_modal_4");

        // Elements inside modalValid
        const verifyBtn = modalValid.querySelector("#verifyBtn");
        const modalValidMessage = modalValid.querySelector("#modalMessage");
        const badgeContainer = modalValid.querySelector("span.mb-8");

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
                    selectedCamera = allCameras.find(cam =>
                        /back|rear|environment/i.test(cam.label)
                    );
                    if (!selectedCamera) selectedCamera = allCameras[allCameras.length - 1];
                } else {
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
                () => {}
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

        // --- FLIP CAMERA ---
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

                console.log("Response:", data);

                if (data.status === "invalid") {
                    modalInvalid.querySelector("#modalMessage").textContent = "Card does not exist !!";
                    modalInvalid.showModal();
                } else if (data.status === "valid") {
                    // Show modal with "not checked-in" state
                    modalValidMessage.textContent = data.name;
                    badgeContainer.innerHTML = `
                    <div class="badge badge-soft badge-primary">Double</div>
                    <div class="badge badge-soft badge-success">Not checked-in</div>
                `;
                    verifyBtn.style.display = "inline-block";
                    modalValid.showModal();

                    // --- WHEN CHECK-IN IS CLICKED ---
                    verifyBtn.onclick = async () => {
                        verifyBtn.disabled = true;
                        verifyBtn.innerHTML = `<i class="fa fa-spinner fa-spin mr-1"></i> Checking...`;

                        const markRes = await fetch(
                            `/user/verify-qr?code=${encodeURIComponent(currentQR)}&mark=1`);
                        const markData = await markRes.json();

                        if (markData.status === "checked_in") {
                            // Update modal contents dynamically
                            modalValid.querySelector("h3.text-6xl").classList.remove("text-success");
                            modalValid.querySelector("h3.text-6xl").classList.add("text-accent");

                            modalValid.querySelector("i.fa-circle-check").classList.remove("text-success");
                            modalValidMessage.textContent = markData.name;
                            badgeContainer.innerHTML = `
                            <div class="badge badge-soft badge-primary">Double</div>
                            <div class="badge badge-soft badge-secondary">Used</div>
                        `;
                            verifyBtn.style.display = "none";
                            modalValid.querySelector("#modalTitle").textContent = "Checked In ✅";
                        } else {
                            verifyBtn.disabled = false;
                            verifyBtn.textContent = "Try Again";
                        }
                    };
                } else if (data.status === "already_checked") {
                    modalUsed.querySelector("#modalMessage").textContent = data.name;
                    modalUsed.showModal();
                }

            } catch (err) {
                console.error("Error verifying:", err);
                modalInvalid.querySelector("#modalMessage").textContent = "Error verifying card";
                modalInvalid.showModal();
            }
        }

        // --- RESUME AFTER MODAL CLOSE ---
        document.querySelectorAll("dialog").forEach(modal => {
            modal.addEventListener("close", async () => {
                currentQR = null;
                setTimeout(async () => {
                    try {
                        await html5QrCode.resume();
                    } catch (err) {
                        console.log("Scanner resume ignored:", err);
                    }
                }, 100);
            });
        });
    </script> --}}

    {{-- <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;

        // const eventId = "{{ $event->id }}";
        const eventId = @json($event->id);
        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera');
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const canvas = document.getElementById('reader');

        // Modals
        const modalInvalid = document.getElementById("my_modal_2");
        const modalValid = document.getElementById("my_modal_3");
        const modalUsed = document.getElementById("my_modal_4");

        // Elements inside modalValid
        const verifyBtn = modalValid.querySelector("#verifyBtn");
        const modalValidMessage = modalValid.querySelector("#modalMessage");
        const badgeContainer = modalValid.querySelector("span.mb-8");
        const modalTitle = modalValid.querySelector("#modalTitle");
        const bigIcon = modalValid.querySelector("h3.text-6xl i");

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
                    selectedCamera = allCameras.find(cam => /back|rear|environment/i.test(cam.label));
                    if (!selectedCamera) selectedCamera = allCameras[allCameras.length - 1];
                } else {
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
                () => {}
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

        // --- FLIP CAMERA ---
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
                const response = await fetch(
                    `/user/verify-qr?code=${encodeURIComponent(decodedText)}&event_id=${eventId}`);
                const data = await response.json();
                console.log("Response:", data);

                if (data.status === "invalid") {
                    modalInvalid.querySelector("#modalMessage").textContent = "Card does not exist !!";
                    modalInvalid.showModal();
                } else if (data.status === "valid") {
                    modalValidMessage.textContent = data.name;
                    badgeContainer.innerHTML = `
                    <div class="badge badge-soft ${data.type == 'single' ? 'badge-primary' : 'badge-secondary'}">${data.type}</div>
                    <div class="badge badge-soft badge-success">Not checked-in</div>
                `;
                    modalTitle.textContent = "Valid Card";
                    bigIcon.className = "fa fa-circle-check text-success";
                    verifyBtn.style.display = "inline-block";
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = `<i class="fa-solid fa-square-check mr-1" > </i> Check-in`;
                    modalValid.showModal();

                    verifyBtn.onclick = async () => {
                        verifyBtn.disabled = true;
                        verifyBtn.innerHTML = `<i class="fa fa-spinner fa-spin mr-1"></i> Checking...`;

                        try {
                            const markRes = await fetch(
                                `/user/verify-card?code=${encodeURIComponent(currentQR)}&mark=1`);
                            const markData = await markRes.json();

                            if (markData.status === "checked_in") {
                                modalTitle.textContent = "Checked In";
                                bigIcon.className = "fa fa-circle-check text-accent";
                                modalValidMessage.textContent = markData.name;
                                badgeContainer.innerHTML = `
                                <div class="badge badge-soft ${markData.type == 'single' ? 'badge-primary' : 'badge-secondary'}">Double</div>
                                <div class="badge badge-soft badge-secondary">Used</div>
                            `;
                                verifyBtn.style.display = "none";
                            } else {
                                verifyBtn.disabled = false;
                                verifyBtn.innerHTML = "Try Again";
                            }
                        } catch (error) {
                            console.error("Error marking check-in:", error);
                            verifyBtn.disabled = false;
                            verifyBtn.innerHTML = "Try Again";
                        }
                    };
                } else if (data.status === "already_checked") {
                    modalUsed.querySelector("#modalMessage").textContent = data.name;
                    modalUsed.showModal();
                }

            } catch (err) {
                console.error("Error verifying:", err);
                modalInvalid.querySelector("#modalMessage").textContent = "Error verifying card";
                modalInvalid.showModal();
            }
        }

        // --- RESUME AFTER MODAL CLOSE ---
        document.querySelectorAll("dialog").forEach(modal => {
            modal.addEventListener("close", async () => {
                currentQR = null;
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = `<i class="fa-solid fa-square-check mr-1"></i> Check-in`;

                setTimeout(async () => {
                    try {
                        await html5QrCode.resume();
                    } catch (err) {
                        console.log("Scanner resume ignored:", err);
                    }
                }, 200);
            });
        });
    </script> --}}

    <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;
        let currentCameraId = null;
        let allCameras = [];
        let isRunning = false;

        const eventId = @json($event->id);
        const startBtn = document.getElementById('startCamera');
        const stopBtn = document.getElementById('stopCamera');
        const flipBtn = document.getElementById('flipCamera');
        const cameraIcon = document.querySelector('.camera-icon');
        const textQr = document.querySelector('.textqr');
        const canvas = document.getElementById('reader');

        // Modals (keep dialog elements, but use unique inner IDs)
        const modalInvalid = document.getElementById("my_modal_2");
        const modalValid = document.getElementById("my_modal_3");
        const modalUsed = document.getElementById("my_modal_4");

        // Elements inside modalValid (unique IDs)
        const valid_verifyBtn = modalValid.querySelector("#valid_modal_verifyBtn");
        const valid_message = modalValid.querySelector("#valid_modal_message");
        const valid_badge_container = modalValid.querySelector("#valid_badge_container");
        const used_badge_container = modalUsed.querySelector("#used_badge_container");
        const valid_title = modalValid.querySelector("#valid_modal_title");
        const valid_big_icon = modalValid.querySelector("#valid_modal_big_icon");

        // Elements inside modalInvalid / modalUsed
        const invalid_message = modalInvalid.querySelector("#invalid_modal_message");
        const used_message = modalUsed.querySelector("#used_modal_message");
        const used_title = modalUsed.querySelector("#used_modal_title");
        // For the checkbox modal (if used elsewhere)
        const qrModalCheckbox = document.getElementById('qrModal');
        const qr_modal_verifyBtn = document.getElementById('qr_modal_verifyBtn');
        const qr_modal_title = document.getElementById('qr_modal_title');
        const qr_modal_message = document.getElementById('qr_modal_message');

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
                    selectedCamera = allCameras.find(cam => /back|rear|environment/i.test(cam.label));
                    if (!selectedCamera) selectedCamera = allCameras[allCameras.length - 1];
                } else {
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
                () => {}
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

        // --- FLIP CAMERA ---
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
                const response = await fetch(
                    `/user/verify-qr?code=${encodeURIComponent(decodedText)}&event_id=${eventId}`);
                const data = await response.json();
                console.log("Response:", data);

                if (data.status === "invalid") {
                    invalid_message.textContent = "Card does not exist !!";
                    modalInvalid.showModal();
                } else if (data.status === "valid") {
                    valid_message.textContent = data.name;
                    valid_badge_container.innerHTML = `
                    <div class="badge badge-soft ${data.type == 'single' ? 'badge-primary' : 'badge-secondary'}">${data.type}</div>
                    <div class="badge badge-soft badge-success">Not checked-in</div>
                `;
                    valid_title.textContent = "Valid Card";
                    valid_big_icon.className = "fa fa-circle-check text-success";
                    valid_verifyBtn.style.display = "inline-block";
                    valid_verifyBtn.disabled = false;
                    valid_verifyBtn.innerHTML = `<i class="fa-solid fa-square-check mr-1" > </i> Check-in`;
                    modalValid.showModal();

                    valid_verifyBtn.onclick = async () => {
                        valid_verifyBtn.disabled = true;
                        valid_verifyBtn.innerHTML = `<i class="fa fa-spinner fa-spin mr-1"></i> Checking...`;

                        try {
                            const markRes = await fetch(
                                `/user/verify-card?code=${encodeURIComponent(currentQR)}&mark=1`);
                            const markData = await markRes.json();

                            if (markData.status === "checked_in") {
                                valid_title.textContent = "Checked In";
                                valid_big_icon.className = "fa fa-circle-check text-accent";
                                valid_message.textContent = markData.name;
                                valid_badge_container.innerHTML = `
                                <div class="badge badge-soft ${markData.type == 'single' ? 'badge-primary' : 'badge-secondary'}">${markData.type}</div>
                                <div class="badge badge-soft badge-secondary">Used</div>
                                <p class="p-2">Card Checked in </p>
                            `;
                                valid_verifyBtn.style.display = "none";
                            } else {
                                valid_verifyBtn.disabled = false;
                                valid_verifyBtn.innerHTML = "Try Again";
                            }
                        } catch (error) {
                            console.error("Error marking check-in:", error);
                            valid_verifyBtn.disabled = false;
                            valid_verifyBtn.innerHTML = "Try Again";
                        }
                    };
                } else if (data.status === "already_checked") {
                    used_message.textContent = data.name;
                    used_badge_container.innerHTML = `
                                <div class="badge badge-soft ${data.type == 'single' ? 'badge-primary' : 'badge-secondary'}">${data.type}</div>
                                <div class="badge badge-soft badge-secondary">Used</div>
                                <p class="p-2">Card Checked in </p>`;
                    modalUsed.showModal();
                }

            } catch (err) {
                console.error("Error verifying:", err);
                invalid_message.textContent = "Error verifying card";
                modalInvalid.showModal();
            }
        }

        // --- RESUME AFTER MODAL CLOSE ---
        document.querySelectorAll("dialog").forEach(modal => {
            modal.addEventListener("close", async () => {
                currentQR = null;

                // reset valid modal verify button if it exists
                if (valid_verifyBtn) {
                    valid_verifyBtn.disabled = false;
                    valid_verifyBtn.innerHTML =
                        ` < i class = "fa-solid fa-square-check mr-1" > < /i> Check-in`;
                }

                setTimeout(async () => {
                    try {
                        await html5QrCode.resume();
                    } catch (err) {
                        console.log("Scanner resume ignored", err);
                    }
                }, 200);
            });
        });
    </script>
@endsection
