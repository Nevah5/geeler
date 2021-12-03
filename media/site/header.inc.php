<div class="header">
    <a href="../../../../../">
        <div id="logo">
            <img src="../../../../media/icon/logo_small_icon.png">
            <p><span>g</span><span id="a">e</span><span id="b">e</span><span id="c">l</span><span id="d">e</span><span id="e">r</span></p>
        </div>
    </a>
    <div id="icon">
        <i class="fa fa-bars" aria-hidden="true" id="icon_dropdown" onclick="dropdown_open()" style="display: inline-block;"></i>
        <i class="fa fa-times" aria-hidden="true" id="icon_dropdown_close" onclick="dropdown_close()" style="display: none;"></i>
    </div>
    <div id="dropdown">
        <ul>
            <li><a href="../../../../"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
            <li><a href="../../../../../support/"><i class="fa fa-question" aria-hidden="true"></i> Support</a></li>
            <li><a href="../../../../../statistics/"><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistics</a></li>
            <li><a href="../../../../../settings/"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
            <li><a href="../../../../../account/"><i class="fa fa-user" aria-hidden="true"></i><?php if($_SESSION['login'] != true){ ?> Account<?php }else{ echo ' ' . $_SESSION['username']; }?></a></li>
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
        src: url("../../../../media/fonts/Pervitina-Dex-FFP.ttf");
    }.header{
        background-color: var(--white2);
        border-bottom: var(--logo2) solid 3px;
    }.header #dropdown{
        background-color: var(--white2);
        display: none;
        border-bottom: var(--logo2) solid 3px;
        border-left: var(--logo2) solid 3px;
    }.header #dropdown li{
        list-style-type: none;
        color: var(--logo2);
        font-family: var(--standart_font);
    }.header #dropdown li a{
        text-decoration: none;
        color: var(--logo2);
    }

    #logo p{
        font-family: logo, monospace, 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }#logo p{
        color: var(--logo1);
    }#logo p #a{
        color: var(--logo2);
    }#logo p #b{
        color: var(--logo3);
    }#logo p #c{
        color: var(--logo4);
    }#logo p #d{
        color: var(--logo5);
    }#logo p #e{
        color: var(--logo6);
    }
    #icon_dropdown, #icon_dropdown_close, #icon_settings{
        color: var(--logo2);
    }#icon_dropdown:hover, #icon_dropdown_close:hover{
        cursor: pointer;
    }
</style>
<?php }else{ ?>
<style>
    :root{
        --white1: #1a1a2e;
        --white2: #16213e;

        --llogo1: #2A3C67;
        --llogo2: #405A9B;
        --llogo3: #3C62C1;
        --llogo4: #6481CA;
        --llogo5: #7699F0;
        --llogo6: #95b2fc;

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
        src: url("../../../../media/fonts/Pervitina-Dex-FFP.ttf");
    }.header{
        background-color: var(--white2);
        border-bottom: var(--logo2) solid 3px;
    }.header #dropdown{
        background-color: var(--white2);
        display: none;
        border-bottom: var(--logo2) solid 3px;
        border-left: var(--logo2) solid 3px;
    }.header #dropdown li{
        list-style-type: none;
        color: var(--logo2);
        font-family: var(--standart_font);
    }.header #dropdown li a{
        text-decoration: none;
        color: var(--logo2);
    }

    #logo p{
        font-family: logo, monospace, 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }#logo p{
        color: var(--llogo3);
    }#logo p #a{
        color: var(--llogo3);
    }#logo p #b{
        color: var(--llogo3);
    }#logo p #c{
        color: var(--llogo3);
    }#logo p #d{
        color: var(--llogo3);
    }#logo p #e{
        color: var(--llogo3);
    }
    #icon_dropdown, #icon_dropdown_close, #icon_settings{
        color: var(--logo2);
    }#icon_dropdown:hover, #icon_dropdown_close:hover{
        cursor: pointer;
    }
</style>
<?php } ?>
<style>
    /*Smartphones (Portrait and Landscape) */
    @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }
        .header{
            top: 0;
            height: 340px;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: fixed;
            z-index: 99;
            margin-bottom: 80px;
        }.header #dropdown{
            position: fixed;
            right: 0;
            top: 343px;
            height: 50%;
            max-height: 900px;
            min-height: 500px;
            width: fit-content;
            text-align: center;
            padding-left: 50px;
            padding-top: 50px;
            z-index: 100;
            word-wrap: break-word;
            animation: dropdown .4s 1 forwards;
        }.header #dropdown ul{
            animation: dropdown_text .4s 1 forwards;
        }.header #dropdown li{
            white-space: nowrap;
            font-size: 3rem;
            margin-bottom: 10px;
            margin-right: 40px;
            word-wrap: break-word;
        }

        .header #logo{
            margin-left: 35px;
            height: 300px;
            width: 300px;
            left: 150px;
            top: 150px;
            transform: translate(-50%,-50%);
            position: absolute;
        }.header #logo:hover{
            cursor: pointer;
        }.header #logo img{
            height: 40%;
            width: auto;
            transform: translate(-50%,-50%);
            position: absolute;
            left: 50%;
            top: 40%;
        }.header #logo p{
            transform: translate(0,55%);
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 75px;
        }.header #dropdown_icon{
            font-size: 120px;
            position: absolute;
            width: 100%;
            right: 25px;
        }#icon{
            float: right;
            transform: translate(0,-50%);
            top: 50%;
            right: 50px;
            position: absolute;
            z-index: 105;
        }#icon_dropdown, #icon_dropdown_close{
            font-size: 140px;
        }#icon_dropdown_close{
            font-size: 160px;
            animation: close .1s 1 forwards;
        }
        @keyframes close {
            0%{
                transform: rotate(-30deg);
            }100%{
                transform: rotate(0deg);
            }
        }
        @keyframes dropdown {
            0%{
                height: 0;
            }100%{
                height: 20%;
                max-height: 500px;
            }
        }@keyframes dropdown_text {
            0%{
                opacity: 0;
            }70%{
                opacity: 0;
            }100%{
                opacity: 1;
            }
        }
    }
    /* Tablets (Portrait and Landscape) */
    @media only screen and (min-device-width : 481px) and (max-device-width : 1024px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }
        .header{
            top: 0;
            height: 100px;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: fixed;
            z-index: 99;
            margin-bottom: 20px;
        }.header #dropdown{
            position: fixed;
            right: 0;
            top: 103px;
            height: 20%;
            max-height: 500px;
            min-height: 250px;
            width: fit-content;
            text-align: center;
            padding-left: 50px;
            padding-top: 50px;
            z-index: 100;
            animation: dropdown .4s 1 forwards;
        }.header #dropdown ul{
            animation: dropdown_text .4s 1 forwards;
        }.header #dropdown li{
            white-space: nowrap;
            font-size: 1.3rem;
            margin-bottom: 10px;
            margin-right: 40px;
            word-wrap: break-word;
        }
        .header #logo{
            height: 100px;
            width: 280px;
            left: 10px;
            top: 0px;
            position: absolute;
        }.header #logo:hover{
            cursor: pointer;
        }.header #logo img{
            height: 80%;
            width: auto;
            transform: translate(-50%,-50%);
            position: absolute;
            left: 50px;
            top: 50%;
        }.header #logo p{
            transform: translate(20%,50%);
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            font-size: 50px;
            text-align: center;
        }.header #dropdown_icon{
            font-size: 60px;
            position: absolute;
            width: 100%;
            right: 25px;
        }#icon{
            float: right;
            transform: translate(0,-50%);
            top: 50%;
            right: 50px;
            position: absolute;
            z-index: 105;
        }#icon_dropdown, #icon_dropdown_close{
            font-size: 60px;
        }#icon_dropdown_close{
            font-size: 70px;
            animation: close .1s 1 forwards;
        }
        @keyframes close {
            0%{
                transform: rotate(-30deg);
            }100%{
                transform: rotate(0deg);
            }
        }
        @keyframes dropdown {
            0%{
                height: 0;
            }100%{
                height: 20%;
                max-height: 500px;
            }
        }@keyframes dropdown_text {
            0%{
                opacity: 0;
            }70%{
                opacity: 0;
            }100%{
                opacity: 1;
            }
        }
    }
    /* Desktops and Laptops */
    @media only screen and (min-device-width : 1025px) and (max-width : 900px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }
        .header{
            top: 0;
            height: 100px;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: fixed;
            z-index: 99;
            margin-bottom: 20px;
        }.header #dropdown{
            position: fixed;
            right: 0;
            top: 103px;
            height: 20%;
            max-height: 500px;
            min-height: 250px;
            width: fit-content;
            text-align: center;
            padding-left: 50px;
            padding-top: 50px;
            z-index: 100;
            animation: dropdown .4s 1 forwards;
        }.header #dropdown ul{
            animation: dropdown_text .4s 1 forwards;
        }.header #dropdown li{
            white-space: nowrap;
            font-size: 1.3rem;
            margin-bottom: 10px;
            margin-right: 40px;
            word-wrap: break-word;
        }
        .header #logo{
            height: 100px;
            width: 280px;
            left: 10px;
            top: 0px;
            position: absolute;
        }.header #logo:hover{
            cursor: pointer;
        }.header #logo img{
            height: 80%;
            width: auto;
            transform: translate(-50%,-50%);
            position: absolute;
            left: 50px;
            top: 50%;
        }.header #logo p{
            transform: translate(20%,50%);
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            font-size: 50px;
            text-align: center;
        }.header #dropdown_icon{
            font-size: 60px;
            position: absolute;
            width: 100%;
            right: 25px;
        }#icon{
            float: right;
            transform: translate(0,-50%);
            top: 50%;
            right: 50px;
            position: absolute;
            z-index: 105;
        }#icon_dropdown, #icon_dropdown_close{
            font-size: 60px;
        }#icon_dropdown_close{
            font-size: 70px;
            animation: close .1s 1 forwards;
        }
        @keyframes close {
            0%{
                transform: rotate(-30deg);
            }100%{
                transform: rotate(0deg);
            }
        }
        @keyframes dropdown {
            0%{
                height: 0;
            }100%{
                height: 20%;
                max-height: 500px;
            }
        }@keyframes dropdown_text {
            0%{
                opacity: 0;
            }70%{
                opacity: 0;
            }100%{
                opacity: 1;
            }
        }
    }
    @media only screen and (min-device-width : 1025px) and (min-width : 900px) {
        @font-face {
            font-family: logo;
            src: url("../fonts/Pervitina-Dex-FFP.ttf");
        }
        .header{
            top: 0;
            height: 100px;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            position: fixed;
            z-index: 99;
            margin-bottom: 20px;
        }.header #dropdown{
            position: fixed;
            right: 0;
            top: 103px;
            height: 350px;
            width: fit-content;
            text-align: center;
            padding-left: 50px;
            padding-top: 50px;
            z-index: 100;
            animation: dropdown .4s 1 forwards;
        }.header #dropdown ul{
            animation: dropdown_text .4s 1 forwards;
        }.header #dropdown li{
            white-space: nowrap;
            font-size: 2rem;
            margin-bottom: 10px;
            margin-right: 40px;
            word-wrap: break-word;
        }

        .header #logo{
            height: 100px;
            width: 280px;
            left: 10px;
            top: 0px;
            position: absolute;
        }.header #logo:hover{
            cursor: pointer;
        }.header #logo img{
            height: 80%;
            width: auto;
            transform: translate(-50%,-50%);
            position: absolute;
            left: 50px;
            top: 50%;
        }.header #logo p{
            transform: translate(20%,50%);
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            font-size: 50px;
            text-align: center;
        }.header #dropdown_icon{
            font-size: 60px;
            position: absolute;
            width: 100%;
            right: 25px;
        }#icon{
            float: right;
            transform: translate(0,-50%);
            top: 50%;
            right: 50px;
            position: absolute;
            z-index: 105;
        }#icon_dropdown, #icon_dropdown_close{
            font-size: 60px;
        }#icon_dropdown_close{
            font-size: 70px;
            animation: close .1s 1 forwards;
        }
        @keyframes close {
            0%{
                transform: rotate(-30deg);
            }100%{
                transform: rotate(0deg);
            }
        }
        @keyframes dropdown {
            0%{
                height: 0;
            }100%{
                height: 350px;
            }
        }@keyframes dropdown_text {
            0%{
                opacity: 0;
            }70%{
                opacity: 0;
            }100%{
                opacity: 1;
            }
        }
    }
</style>
<script>
    function dropdown_close() {
        document.getElementById('dropdown').style.display = 'none';
        document.getElementById('icon_dropdown_close').style.display = 'none';
        document.getElementById('icon_dropdown').style.display = 'inline-block';
    }
    
    function dropdown_open() {
        document.getElementById('dropdown').style.display = 'inline-block';
        document.getElementById('icon_dropdown_close').style.display = 'inline-block';
        document.getElementById('icon_dropdown').style.display = 'none';
    }
</script>