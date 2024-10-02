<?php
    $page_name = 'thanks';
    $meta_title = 'Vă Mulțumim - Fleboxin';
    $meta_description = 'Vă mulțumim pentru comanda dvs. de Fleboxin, în cel mai scurt timp posibil veți fii contactat de unul dintre consultanți noștri!';

    if (!isset($_SESSION['order_id']) || !isset($_SESSION['order_name'])) {
        header("Location: ./");
    }
?>
<section>
    <div class="container">
        <div class="row pt-4">
            <div class="col">
                <div class="order-info__content order-info__content_light_green mb-sm-3 mb-2">
                    <div class="order-info__info-line">
                        <div class="d-flex align-items-center">
                            <img class="order-is-issued__img" src="assets/img/order_green.svg" alt="order">
                            <p class="order-info__title m-0"><?php echo $_SESSION['order_name']; ?>, vă mulțumim pentru comanda dumneavoastră!</p>
                        </div>
                    </div>
                    <p class="order-info__text m-0">Un specialist în produse <span class="current-product__name font-weight-bold">Fleboxin</span> vă va contacta în curând pentru a răspunde întrebărilor dvs. și pentru a clarifica detaliile referitoare la livrare.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="order-product__content mb-3">
                    <div class="order-product__item current-product">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="order-product-spec-wrap">
                                <p class="order-id">Numărul comenzii dvs. este: <span class="order-id__value">ID-<?php echo $_SESSION['order_id']; ?></span></p>
                                <p class="current-product__text"><span class="current-product__name">Fleboxin  </span></p>
                                <p class="current-product__description m-0"></p>
                            </div>
                            <img class="current-product__img" src="assets/img/small-product.png" alt="product">
                        </div>
                    </div>
                    
                    <div class="order-product__item product-guarantee">
                        <div class="d-flex align-items-center"><img class="label label_img guarantee-label_img" src="assets/img/guarantee.png" alt="guarantee">
                            <p class="product-guarantee_text">Garantăm satisfacția 100% sau returnăm banii în termen de 365 de zile.</p>
                        </div>
                    </div>
                    <div class="order-product__item product-confirmed">
                        <div class="d-flex align-items-center"><img class="label label_img" src="assets/img/confirmed.png" alt="confirmed">
                            <p class="product-confirmed_text">Siguranța și eficacitatea produsului sunt confirmate clinic.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>