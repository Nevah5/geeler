<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <div id="acceptsecurity" class="usagegeelernet">
            <h2>Nutzung von geeler.net</h2>
            <p>Wenn du geeler.net nutzt, akzeptierst du die <a href="../../../../security">Datenschutzerklärung</a> und das <a href="../../../../impressum">Impressum</a>.</p>
            <a id="close" onclick="usagegeelernetclose()" href="?accept">Schliessen</a>
        </div>
    </body>

    <script>
        function usagegeelernetclose(){
            document.getElementById('acceptsecurity').style.display = 'none';
        }
    </script>

    <?php 
        if($_COOKIE['theme'] != 'dark'){
    ?>
    <style>
        :root{
            --white1: #D5DDF2;
            --white2: #F1F4FB;
            --link: #1c2b50;
            --bg: rgba(241, 244, 251, 0.8);

            --logo1: #2A3C67;
            --logo2: #405A9B;
            --logo3: #3C62C1;
            --logo4: #6481CA;
            --logo5: #7699F0;
            --logo6: #95b2fc;

            --important: #e63232;

            --overlay: rgba(10, 10, 10, 0.9);

            --standart_font: Verdana, Geneva, Tahoma, sans-serif;
        }
    </style>
    <?php }else{ ?>
    <style>
    :root{
        --white1: #1a1a2e;
        --white2: #16213e;

        --bg: rgba(22, 33, 62, 0.75);

        --logo1: #567bd1;
        --logo2: #5c81dd;
        --logo3: #436bce;
        --logo4: #6481CA;
        --logo5: #617dc5;
        --logo6: #7c94d1;

        --important: #e63232;

        --devbg: rgba(10, 10, 10, 0.4);

        --standart_font:Verdana, Geneva, Tahoma, sans-serif;
    }
    </style>
    <?php } ?>
    <style>
        body{
            margin: 0;
            padding: 0;
        }.usagegeelernet{
            border-top: var(--logo2) solid 5px;
            background: var(--bg);
            color: var(--logo2);
            font-family: var(--standart_font);
        }.usagegeelernet a{
            color: var(--link);
        }.usagegeelernet a#close{
            cursor: pointer;
            color: var(--logo2);
            border: var(--logo2) solid;
        }
        /*Smartphones (Portrait and Landscape) */
        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
            .usagegeelernet{
                z-index: 1000;
                position: fixed;
                width: 100%;
                bottom: 0;
                padding: 30px;
                border-top: solid 10px;
                font-weight: 1000;
            }.usagegeelernet h2{
                font-size: 4rem;
                width: 100%;
                margin-bottom: 40px;
            }.usagegeelernet p{
                font-size: 2rem;
                width: 100%;
                margin-bottom: 200px;
            }.usagegeelernet a#close{
                position: absolute;
                padding: 40px 90px;
                border-width: 8px;
                font-size: 2.5rem;
                transform: translate(0,-100%);
            }
        }
        /* Tablets (Portrait and Landscape) */
        @media only screen and (min-device-width : 481px) and (max-device-width : 1024px) {
            .usagegeelernet{
                z-index: 1000;
                position: fixed;
                width: 100%;
                bottom: 0;
                padding: 30px;
                border-top: solid 5px;
                font-weight: 1000;
            }.usagegeelernet p{
                width: 80%;
                margin-bottom: 40px;
            }.usagegeelernet a#close{
                position: absolute;
                padding: 15px;
                border-width: 4px;
                right: 80px;
                transform: translate(0, -200%);
            }
        }
        /* Desktops and Laptops */
        @media only screen and (min-device-width : 1025px) and (max-width : 900px) {
            .usagegeelernet{
                z-index: 1000;
                position: fixed;
                width: 100%;
                bottom: 0;
                padding: 30px;
                border-top: solid 5px;
                font-weight: 1000;
            }.usagegeelernet p{
                width: 100%;
                margin-bottom: 40px;
            }.usagegeelernet a#close{
                position: relative;
                padding: 15px;
                border-width: 4px;
            }
        }
        @media only screen and (min-device-width : 1025px) and (min-width : 900px) {
            .usagegeelernet{
                z-index: 1000;
                position: fixed;
                width: 100%;
                bottom: 0;
                padding: 30px;
                border-top: solid 5px;
                font-weight: 1000;
            }.usagegeelernet p{
                width: 80%;
            }.usagegeelernet a#close{
                position: absolute;
                padding: 15px;
                border-width: 4px;
                right: 80px;
                transform: translate(0, -130%);
            }
        }
    </style>
</html>