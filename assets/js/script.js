document.addEventListener(
    "DOMContentLoaded",
    function () {

        /*
        ------------------------------------------
        PREVIEW NAMA FILE
        ------------------------------------------
        */

        const fileInput =
            document.getElementById("bukti");

        const fileName =
            document.getElementById(
                "fileName"
            );


        if (
            fileInput &&
            fileName
        ) {

            fileInput.addEventListener(
                "change",
                function () {

                    if (
                        this.files.length > 0
                    ) {

                        fileName.innerText =
                            this.files[0].name;

                    } else {

                        fileName.innerText =
                            "Belum ada file";
                    }
                }
            );
        }


        /*
        ------------------------------------------
        KONFIRMASI1
        ------------------------------------------
        */

        const confirmButtons =
            document.querySelectorAll(
                "[data-confirm]"
            );


        confirmButtons.forEach(
            function (button) {

                button.addEventListener(
                    "click",
                    function (event) {

                        const message =
                            this.dataset.confirm;

                        if (
                            !confirm(message)
                        ) {

                            event.preventDefault();
                        }

                    }
                );

            }
        );

    }
);