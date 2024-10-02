<?php
    $page_name = 'contact';
    $meta_title = 'Contact - Fleboxin';
    $meta_description = 'Vă mulțumim pentru interesul acordat. În cel mai scurt timp posibil, unul dintre consilierii noștri vă va raspunde la orice întrebare aveți.';
?>
<section>
    <div class="feedback__success">
        <P>Mesajul dumneavoastră a fost trimis cu succes, în cel mai scurt timp posibil unul dintre consilieri noștri vă va contacta.</br>Vă mulțumim pentru interesul acordat!</p>
    </div>
    <div class="feedback">
        <div class="feedback__title">Contactați-ne</div>
        <form class="feedback__form al-form" id="feedback__form">
            <select class="feedback__country al-country send-data" name="country">
                <option value="RO" selected="selected">Romania</option>
            </select>
            <input class="feedback__input send-data" type="text" name="name" placeholder="Numele complet">
            <input class="feedback__input send-data" type="email" name="email" placeholder="Adresa de Email">
            <input class="feedback__input send-data" type="tel" name="phone" placeholder="Numărul de telefon">
            <textarea class="feedback__input feedback__input_textarea send-data" name="message" cols="30" rows="10" placeholder="Mesajul"></textarea>
            <input type="hidden" name="csrf_token" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button class="feedback__submit" type="submit">Trimite</button>
        </form>
    </div>
</section>