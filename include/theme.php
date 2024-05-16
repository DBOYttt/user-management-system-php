<?php
echo '
<!DOCTYPE html>
<html>
<head>
    <style id="themeStyle">
        html {
            transition: filter 0.5s ease;
        }
        #theme-switch-wrapper {
            position: fixed;
            top: 1em;
            right: 1em;
            display: flex;
            align-items: center;
        }

        .theme-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .theme-switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider round"></div>
        </label>
    </div>

    <script>
        var checkbox = document.querySelector("input[id=checkbox]");
        var currentTheme = localStorage.getItem("theme");

        if (currentTheme) {
            document.documentElement.style.filter = currentTheme;
            checkbox.checked = currentTheme.includes("invert");
        }

        checkbox.addEventListener("change", function() {
            if(this.checked) {
                document.documentElement.style.filter = "invert(1) hue-rotate(180deg)";
                localStorage.setItem("theme", "invert(1) hue-rotate(180deg)");
            } else {
                document.documentElement.style.filter = "none";
                localStorage.setItem("theme", "none");
            }
        });
    </script>
</body>
</html>
';
