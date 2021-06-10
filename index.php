<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>Sort</title>

    <script>

        // Items
        const DragBaseData = [
            "Item 1",
            "Item 2",
            "Item 3",
            "Item 4",
            "Item 5",
            "Item 6",
        ];

        window.addEventListener("load", () => {

            // Shuffle list
            ShuffleArray(DragBaseData).forEach((dragData) => {
                // Add item
                const drag_item = GetTemplate("template_drag_item");
                drag_item.id = CreateUUID();
                drag_item.textContent = dragData;
                document.querySelector(".items").appendChild(drag_item);
            });

            // Add targets
            SetDragTargets();
        });

        function SetDragTargets() {
            const parent = document.querySelector(".items");

            // Remove all targets
            parent.querySelectorAll(".drag_target").forEach((ele) => {
                ele.parentElement.removeChild(ele);
            });

            // Insert target before every item
            parent.querySelectorAll(".drag_item").forEach((ele) => {
                const drag_target = GetTemplate("template_drag_target");
                parent.insertBefore(drag_target, ele);
            });

            // Add final target
            const drag_target = GetTemplate("template_drag_target");
            parent.appendChild(drag_target);
        }

        // #region System functions

        /**
         *
         * @param {string} id
         * @returns {HTMLElement}
         */
        function GetTemplate(id) {
            /** @type {HTMLTemplateElement} */
            const ele = document.querySelector(`#${id}`);
            return ele.content.cloneNode(true).children[0];
        }
        /**
         * https://www.tutorialspoint.com/how-to-create-guid-uuid-in-javascript
         * @returns {string}
         * */
        function CreateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        /**
         * Shuffles array in place. ES6 version
         * https://stackoverflow.com/a/6274381/15213858
         * @param {Array} array items An array containing the items.
         * @returns {Array}
         */
        function ShuffleArray(array) {
            let a = array.slice();
            for (let i = a.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [a[i], a[j]] = [a[j], a[i]];
            }
            return a;
        }

        // #endregion

    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2&family=Inter:wght@300;400;500&display=swap');

        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: #273443;
        }

            header > h1 {
                margin: 0px;
            }

        content {
            padding: 20px 0px;
            box-sizing: border-box;
            flex: 1;
        }

        a {
            text-decoration: none;
            cursor: pointer;
            color: rgb(133, 156, 255);
        }

            a:hover {
                text-decoration: underline;
            }

        footer {
            background: #232f3c;
        }

            footer a {
                color: rgb(202, 212, 255);
            }

        .system_bar {
            font-family: 'Baloo 2', cursive;
            color: white;
            width: 100%;
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 10px;
            box-sizing: border-box;
        }
    </style>

</head>
<body>

    <header class="system_bar">
        <h1>Sort - Finde die richtige Reihenfolge</h1>
    </header>
    <content>
        <div class="items"></div>
    </content>
    <footer class="system_bar">
        <div>
            © <?php echo date("Y"); ?> <a target="_blank" href="https://shortdevelopment.github.io/">@ShortDevelopment</a>
            |
            <a target="_blank" href="https://github.com/ShortDevelopment/ClassRoom-Sort">OpenSource</a>
        </div>
    </footer>

    <script>
        function ValidateItems() {
            const parent = document.querySelector(".items");

            const items = parent.querySelectorAll(".drag_item");

            //// Check for correct index
            //items.forEach(/** @param {HTMLElement} ele */(ele, index) => {
            //    const { textContent } = ele;
            //    if (textContent == DragBaseData[index]) {
            //        ele.style.borderColor = "green";
            //    } else {
            //        ele.style.borderColor = "red";
            //    }
            //});

            let wrongBorderCount = 0;

            // Check for correct relative order
            items.forEach(/** @param {HTMLElement} ele */(ele, index) => {
                const { textContent } = ele;
                const index2 = DragBaseData.indexOf(textContent);

                ele.style.borderColor = "";

                let topBorderCorrect = -1;
                let bottomBorderCorrect = -1;

                if (index != 0) {
                    if (DragBaseData[index2 - 1] == items[index - 1].textContent) {
                        ele.style.borderTopColor = "var(--color-correct)";
                        topBorderCorrect = 1;
                    } else {
                        ele.style.borderTopColor = "var(--color-wrong)";
                        topBorderCorrect = 0;
                        wrongBorderCount++;
                    }
                }

                if (index != items.length - 1) {
                    if (DragBaseData[index2 + 1] == items[index + 1].textContent) {
                        ele.style.borderBottomColor = "var(--color-correct)";
                        bottomBorderCorrect = 1;
                    } else {
                        ele.style.borderBottomColor = "var(--color-wrong)";
                        bottomBorderCorrect = 0;
                        wrongBorderCount++;
                    }
                }

                if (topBorderCorrect == 1 && bottomBorderCorrect == 1) {
                    ele.style.borderColor = "var(--color-correct)";
                }else if (topBorderCorrect == 0 && bottomBorderCorrect == 0) {
                    ele.style.borderColor = "var(--color-wrong)";
                }

            });

            if (wrongBorderCount == 0) {
                alert("Wow! Alles richtig!");
            }

        }
    </script>

    <style>
        :root {
            --drag-item-margin: 25px;
            --drag-item-min-height: 15px;
            --drag-item-border-radius: 5px;
            --color-correct: green;
            --color-wrong: red;
        }

        .drag {
            max-width: 700px;
            margin: 0px auto;
            font-size: 20px;
            transition: 0.1s;
        }

        .drag_item {
            border-radius: var(--drag-item-border-radius);
            padding: 5px 10px;
            box-sizing: border-box;
            min-height: 30px;
            border: 4px dashed rgba(0, 0, 0, 0.3);
            background: white;
            cursor: grab;
        }

        .drag_target {
            min-height: var(--drag-item-margin);
            background: transparent;
            box-sizing: border-box;
        }

            .drag_target > div {
                display: none;
                pointer-events: none;
            }

            .drag_target[data-drag-enter] {
                border-radius: var(--drag-item-border-radius);
                padding: 10px 0px;
            }

                .drag_target[data-drag-enter] > div {
                    display: block;
                    border-color: rgba(0, 0, 0, 0.1);
                    border-radius: var(--drag-item-border-radius);
                    padding: 5px 10px;
                    box-sizing: border-box;
                    min-height: 30px;
                    border: 4px dashed rgba(0, 0, 0, 0.1);
                }
    </style>

    <template id="template_drag_item">
        <div class="drag drag_item" draggable="true" ondragstart="DragItemDragStart(this, event);"></div>
    </template>

    <script>
        /**
         *
         * @param {HTMLElement} ele
         * @param {DragEvent} e
         */
        function DragItemDragStart(ele, e) {
            e.dataTransfer.setData("text", ele.id);
        }
    </script>

    <template id="template_drag_target">
        <div class="drag drag_target" ondragover="event.preventDefault();" ondragenter="this.setAttribute('data-drag-enter', '');" ondragleave="this.removeAttribute('data-drag-enter');" ondrop="DragTargetDrop(this, event);">
            <div></div>
        </div>
    </template>

    <script>
        /**
         *
         * @param {HTMLElement} ele
         * @param {DragEvent} e
         */
        function DragTargetDrop(ele, e) {
            e.preventDefault();
            const id = e.dataTransfer.getData("text");
            ele.parentElement.insertBefore(document.getElementById(id), ele);

            // Reset targets
            SetDragTargets();

            // Check if correct & highlight
            ValidateItems();
        }
    </script>

</body>
</html>