<?php

namespace App;

/**
 * Class VillaPeruana
 * @package App
 */
class VillaPeruana
{
    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $quality;

    /**
     * @var
     */
    public $sellIn;

    /**
     * VillaPeruana constructor.
     * @param $name
     * @param $quality
     * @param $sellIn
     */
    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    /**
     * @param $name
     * @param $quality
     * @param $sellIn
     * @return static
     */
    public static function of($name, $quality, $sellIn)
    {
        return new static($name, $quality, $sellIn);
    }


    /**
     * @param $sellIn
     * @param $quality
     * @return mixed
     */
    function qualityLegend($sellIn, $quality)
    {
        return $quality;
    }

    /**
     * @param $sellIn
     * @param $quality
     * @param false $olderQuality
     * @return int|mixed
     */
    function qualitySpecial($sellIn, $quality, $olderQuality = false)
    {
        if (!$olderQuality) {
            if ($sellIn > 5 && $sellIn <= 10) {
                $quality += 2;
            } else if ($sellIn > 0 && $sellIn <= 5) {
                $quality += 3;
            } else if ($sellIn <= 0) {
                $quality = 0;
            } else if ($sellIn > 10) {
                $quality += 1;
            }
        } else {
            if ($sellIn <= 0) {
                $quality += 2;
            } else {
                $quality += 1;
            }
        }

        $quality = ($quality < 50) ? $quality : 50;
        $quality = ($quality > 0) ? $quality : 0;

        return $quality;
    }

    /**
     * @param $sellIn
     * @param $quality
     * @param int $factor
     * @return float|int
     */
    public function qualityGeneral($sellIn, $quality, $factor = 1)
    {
        if ($sellIn <= 0) {
            $quality = $quality - 2 * $factor;
        } else {
            $quality = $quality - 1 * $factor;
        }

        $quality = ($quality <= 50) ? $quality : 50;
        $quality = ($quality > 0) ? $quality : 0;

        return $quality;
    }

    /**
     *
     */
    public function tick()
    {
        if ($this->name == 'Ticket VIP al concierto de Pick Floid') {
            $this->quality = $this->qualitySpecial($this->sellIn, $this->quality);
        } else if ($this->name == 'Pisco Peruano') {
            $this->quality = $this->qualitySpecial($this->sellIn, $this->quality, true);
        } else if ($this->name == 'Tumi de Oro Moche') {
            $this->quality = $this->qualityLegend($this->sellIn, $this->quality);
            $this->sellIn = $this->sellIn + 1;
        } else if ($this->name == 'Café Altocusco') {
            $this->quality = $this->qualityGeneral($this->sellIn, $this->quality, 2);
        } else {
            $this->quality = $this->qualityGeneral($this->sellIn, $this->quality);
        }
        $this->sellIn = $this->sellIn - 1;
    }
}
