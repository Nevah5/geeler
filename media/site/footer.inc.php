<div class="footer">
    <div class="ft">
        <ul>
            <h3>Über das Forum</h3>
            <li><a href="../../../../documentation/">Projekt</a></li>
            <li><a href="../../../../documentation/">Dokumentation</a></li>
            <li><a href="../../../../documentation/">Entwicklung</a></li>
            <li><a href="../../../../review/">Bewertung abgeben</a></li>
        </ul>
        <ul>
            <h3>Informationen</h3>
            <li><a href="../../../../security/">Datenschutz</a></li>
            <li><a href="../../../../security/">Cookies</a></li>
            <li><a href="../../../../impressum/">Impressum</a></li>
            <li><a href="../../../../security/">Copyright</a></li>
        </ul>
    </div>
</div>
<?php 
    if($_COOKIE['theme'] != 'dark'){
?>
<style>
    :root{
        --white1: #D5DDF2;
        --white2: #F1F4FB;

        --logo1: #2A3C67;
        --logo2: #405A9B;
        --logo3: #3C62C1;
        --logo4: #6481CA;
        --logo5: #7699F0;
        --logo6: #95b2fc;

        --important: #e63232;

        --devbg: rgba(10, 10, 10, 0.4);

        --standart_font:Verdana, Geneva, Tahoma, sans-serif;
    }@font-face {
        font-family: logo;
        src: url("../fonts/Pervitina-Dex-FFP.ttf");
    }.footer{
        border-top: var(--logo2) solid 3px;
        background-color: var(--white2);
        margin-top: 20px;
    }.footer .ft{
        font-family: var(--standart_font);
        text-align: center;
    }.footer h3{
        color: var(--logo2);
    }.footer li{
        list-style-type: none;
        color: var(--logo2);
    }.footer li a{
        color: var(--logo2);
        text-decoration: none;
    }#copyright{
        background-color: var(--white2);
        font-family: var(--standart_font);
        color: var(--logo2);
        font-weight: 1000;
    }
</style>
<?php }else{ ?>
<style>
    :root{
        --white1: #1a1a2e;
        --white2: #16213e;

        --logo1: #567bd1;
        --logo2: #5c81dd;
        --logo3: #436bce;
        --logo4: #6481CA;
        --logo5: #617dc5;
        --logo6: #7c94d1;

        --important: #e63232;

        --devbg: rgba(10, 10, 10, 0.4);

        --standart_font:Verdana, Geneva, Tahoma, sans-serif;
    }@font-face {
        font-family: logo;
        src: url("../fonts/Pervitina-Dex-FFP.ttf");
    }.footer{
        border-top: var(--logo2) solid 3px;
        background-color: var(--white2);
        margin-top: 20px;
    }.footer .ft{
        font-family: var(--standart_font);
        text-align: center;
    }.footer h3{
        color: var(--logo2);
    }.footer li{
        list-style-type: none;
        color: var(--logo2);
    }.footer li a{
        color: var(--logo2);
        text-decoration: none;
    }#copyright{
        background-color: var(--white2);
        font-family: var(--standart_font);
        color: var(--logo2);
        font-weight: 1000;
    }
</style>
<?php } ?>
<style>
    /*Smartphones (Portrait and Landscape) */
    @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }.footer{
            height: 560px;
            margin: 0;
            z-index: 97;
        }.footer ul{
            width: 100%;
            margin: 0 15px;
            padding: 0;
            display: inline-flex;
            flex-direction: column;
            flex-wrap: nowrap;
            font-size: 2rem;
        }.footer h3{
            margin-bottom: 5px;
            font-size: 3rem;
        }.footer .ft{
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translate(-50%);
        }#copyright{
            text-align: center;
            padding: 25px;
            margin: 0;
            font-size: .6rem;
        }
    }
    /* Tablets (Portrait and Landscape) */
    @media only screen and (min-device-width : 481px) and (max-device-width : 1024px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }.footer{
            height: 200px;
            margin: 0;
            z-index: 97;
        }.footer .ft{
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 100px;
        }.footer ul{
            width: 100%;
            margin: 0 15px;
            padding: 0;
            display: inline-flex;
            flex-direction: column;
            flex-wrap: nowrap;
            font-size: 1rem;
        }.footer h3{
            margin-bottom: 5px;
            font-size: 1.5rem;
        }.footer .ft{
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translate(-50%);
        }#copyright{
            text-align: center;
            padding: 10px;
            margin: 0;
            font-size: .6rem;
        }
    }
    /* Desktops and Laptops */
    @media only screen and (min-device-width : 1025px) and (max-width : 900px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }.footer{
            height: 300px;
            margin: 0;
            z-index: 97;
        }.footer ul{
            width: 100%;
            margin: 0 15px;
            padding: 0;
            display: inline-flex;
            flex-direction: column;
            flex-wrap: nowrap;
            font-size: 1rem;
        }.footer h3{
            margin-bottom: 5px;
            font-size: 1.5rem;
        }.footer .ft{
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translate(-50%);
        }#copyright{
            text-align: center;
            padding: 10px;
            margin: 0;
            font-size: .6rem;
        }
    }
    @media only screen and (min-device-width : 1025px) and (min-width : 900px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }.footer{
            height: 275px;
            margin: 0;
            z-index: 97;
        }.footer .ft{
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 100px;
        }.footer ul{
            width: 100%;
            margin: 0 15px;
            padding: 0;
            display: inline-flex;
            flex-direction: column;
            flex-wrap: nowrap;
            font-size: 1rem;
        }.footer h3{
            margin-bottom: 5px;
            font-size: 1.5rem;
        }.footer .ft{
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translate(-50%);
        }#copyright{
            text-align: center;
            padding: 10px;
            margin: 0;
            font-size: .6rem;
        }
    }
</style>
<?php echo '<p id="copyright">© 2021 - Geeler.net</p>'; ?>