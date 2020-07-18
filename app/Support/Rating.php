<?php


namespace App\Support;


class Rating
{
    public function stars($rate = 0, $font = 'font-awesome')
    {
        $stars = '';
        if ($font == 'font-awesome') {
            if (round($rate * 2) / 2 == 1) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 2) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 3) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 4) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 5) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 0.5) {
                $stars =
                    '<i class="fa fa-star-half-alt"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 1.5) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star-half-alt"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 2.5) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star-half-alt"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 3.5) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star-half-alt"></i>' .
                    '<i class="far fa-star"></i>';

            } elseif (round($rate * 2) / 2 == 4.5) {
                $stars =
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star"></i>' .
                    '<i class="fa fa-star-half-alt"></i>';
            } else {
                $stars =
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>' .
                    '<i class="far fa-star"></i>';
            }
        }

        return $stars;
    }
}
