<section class="header">
    <div class="sticky block0 m-hide">
        <div class="header-wrapper">
            <div class="d-flex justify-space-between">
                <div class="d-flex">
                    <span class="logo">
                        <a href="<?php echo $_ENV['SITE_URI']; ?>/">Fleboxin</a>
                    </span>
                    <div class="block0__cap ttu">
                        <strong>Asociația mondială </strong>
                        <br>a experților drenajului limfatic
                        <br><strong>îl recomandă!</strong>
                    </div>
                </div>
                <ul class="nav d-flex justify-center m-hide">
                    <li>
                        <a class="nav-link active" href="<?php echo $_ENV['SITE_URI']; ?>/">
                            <i class="fas fa-home"></i> Acasă
                        </a>
                    </li>
                    <?php if ($page_name === 'home') { ?>
                    <li>
                        <a href="javascript:void(0)" class="nav-link toform">
                            <i class="fas fa-cart-plus"></i> Comandă
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a class="nav-link" href="<?php echo $_ENV['SITE_URI']; ?>/contact">
                            <i class="fas fa-envelope"></i> Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Top Navigation Menu -->
    <div class="topnav m-show">
        <a href="<?php echo $_ENV['SITE_URI']; ?>/" class="m-logo">Fleboxin</a>
        <!-- Navigation links (hidden by default) -->
        <div id="my-links">
            <a href="<?php echo $_ENV['SITE_URI']; ?>/" onclick="toggleNavbar()">
                <i class="fas fa-home"></i> Acasă
            </a>
            <a class="toform" href="javascript:void(0)" onclick="toggleNavbar()">
                <i class="fas fa-cart-plus"></i> Comandă
            </a>
            <a href="<?php echo $_ENV['SITE_URI']; ?>/contact" onclick="toggleNavbar()">
                <i class="fas fa-envelope"></i> Contact
            </a>
        </div>
        <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
        <a href="javascript:void(0);" class="icon" onclick="toggleNavbar()">
            <i id="hamburger-icon" class="fa fa-bars"></i>
        </a>
    </div>
    <div class="block1">
        <div class="centering">
            <h1 class="block1__cap ttu">
                Picioare <span class="greenText">frumoase și sănătoase</span>
            </h1>
            <p class="block1__smallCap">Rezultat garantat ca și consecință a cursului complet de aplicare!</p>
            <ul class="block1__list">
                <li class="block1__list__li">
                    <span class="greenText">Eliberează</span> de vizibilitatea inestetică a simptomelor de varicoză!
                </li>
                <li class="block1__list__li">
                    <span class="greenText">Previne și stopează</span> evoluția venelor varicoase!
                </li>
                <li class="block1__list__li">
                    <span class="greenText">Elimină</span> durerea și senzația de greutatea din picioare!
                </li>
                <li class="block1__list__li">Conține doar ingrediente 
                    <span class="greenText">sigure</span> și naturale
                </li>
            </ul>
            <div class="block1__prod prod">
                <img src="assets/img/product.png" alt="Fleboxin">
                <div class="sale">
                    <span class="text">Reducere</span>
                    <div class="sale__numb">50%</div>
                </div>
            </div>
        </div>
        <div class="block1__prices prices">
            <div class="oldPricesText">
                Preț vechi:
                <br>
                <span class="js_old_price_curs al-cost-promo"><?php echo ($_ENV['PRODUCT_PRICE'] * 2); ?> RON</span>
            </div>
            <div class="js_new_price_curs">
                Preț nou:
                <span class="al-cost"><?php echo $_ENV['PRODUCT_PRICE']; ?> RON</span>
            </div>
            <?php if ($page_name === 'home') { ?>
            <div>
                <button class="button toform">
                    <span class="button__text">Comandă</span>
                </button>
            </div>
            <?php } ?>
        </div>
    </div>
</section>