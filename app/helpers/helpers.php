<?php

    function convert_date($value) {
        return date('j F Y', strtotime($value));
    }

    function convert_currency($value) {
        return 'Rp. '.number_format($value).' ,-';
    }

?>