@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card bg-base-100 p-10 border-2 border-stone-700/10">
                <figure class="p-10">
                    <i class="fa fa-camera text-9xl inline"></i>
                </figure>
                <div id="reader" style="width: 320px; margin: auto; border-radius: 12px; overflow: hidden;"></div>
                <div class="card-body items-center text-center">
                    <p>
                        If you already have your gestlist ready and accurate, fire the camera button and lets get scanning
                    </p>
                    <div class="card-actions pt-10">
                        <button id="startCamera" class="btn btn-outline btn-primary">Activate Camera</button>
                        <button id="stopCamera" class="btn btn-secondary">Stop Camera</button>
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
                <button id="verifyBtn" class="btn btn-success">Mark Attended</button>
                <label for="qrModal" class="btn btn-error" id="closeModalBtn">Close</label>
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

    <script type="module">
        const html5QrCode = new Html5Qrcode("reader");
        let currentQR = null;


        const qrModalCheckbox = document.getElementById('qrModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const verifyBtn = document.getElementById('verifyBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // Start camera
        document.getElementById("startCamera").addEventListener("click", async () => {
            try {
                const cameras = await Html5Qrcode.getCameras();
                if (!cameras || cameras.length === 0) return alert("No camera found 😢");

                const cameraId = cameras[0].id;
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
        document.getElementById("stopCamera").addEventListener("click", () => {
            html5QrCode.stop().then(() => console.log("Camera stopped")).catch(console.error);
        });

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
                    modalTitle.textContent = "Guest Found!";
                    modalMessage.textContent = `Name: ${data.name}`;
                    verifyBtn.style.display = "inline-block"; // show attend button
                } else {
                    modalTitle.textContent = "QR Not Found!";
                    modalMessage.textContent = `QR does not belong to this event.`;
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
                    modalMessage.textContent = `✅ Verified: ${data.name}`;
                } else {
                    modalMessage.textContent = `❌ Could not mark attended`;
                }
            } catch (err) {
                modalMessage.textContent = `❌ Error verifying`;
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
    </script>
@endsection
