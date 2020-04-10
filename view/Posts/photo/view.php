<a href="/items/">Вернуться назад</a><br>
<canvas id="canvas" style="border: 1px solid red;"></canvas>
<form method="post">
    <input type="file" id="loadImage" name="file">
</form>

<script>
    function loadImage(src) {
        return new Promise((resolve, reject) => {
            try {
                const image = new Image;
                image.onload = () => resolve(image);
                image.src = src;
            } catch (error) {
                return reject(error);
            }
        });
    }

    function getMouse(element) {
        const mouse = {
            x: 0,
            y: 0,
            dx: 0,
            dy: 0,
            left: false,
            wheel: 0
        };

        mouse.update = () => {
            mouse.dx = 0;
            mouse.dy = 0;
            mouse.wheel = 0;
        };

        element.addEventListener('mousemove', event => {
            const rect = element.getBoundingClientRect();

            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            mouse.dx = x - mouse.x;
            mouse.dy = y - mouse.y;
            mouse.x = x;
            mouse.y = y;
        });

        element.addEventListener('mousedown', event => {
            if (event.button === 0) {
                mouse.left = true;
            }
        });

        element.addEventListener('mouseup', event => {
            if (event.button === 0) {
                mouse.left = false;
            }
        });

        element.addEventListener('mousewheel', event => {
            mouse.wheel = event.deltaY;
            event.preventDefault();
        });

        return (mouse);
    }

    (async function () {
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');
        const mouse = getMouse(canvas);
        const imageParams = {
            offsetX: 0,
            offsetY: 0,
            scale: 1
        };

        let image = await loadImage('/framework/view/Posts/photo/world.jpg');

        canvas.width = 750;
        canvas.height = 750;

        update();
        function update() {
            requestAnimationFrame(update);
            clearCanvas();

            if (mouse.left) {
                imageParams.offsetX += mouse.dx;
                imageParams.offsetY += mouse.dy;
            }

            if (mouse.wheel) {
                imageParams.scale -= mouse.wheel / 1000;
            }
            context.drawImage(
                image,
                0, 0,
                image.width, image.height,
                imageParams.offsetX, imageParams.offsetY,
                image.width * imageParams.scale, image.height * imageParams.scale

            );

            mouse.update();
        }

        function clearCanvas() {
            canvas.width = canvas.width;
        }

        const loadImageInput = document.getElementById('loadImage');
        loadImageInput.addEventListener('change', event => {
            const file = loadImageInput.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                const newImage = new Image();
                newImage.onload = () => {
                    image = newImage
                };
                newImage.src = reader.result;
            };
        });

    })()
</script>