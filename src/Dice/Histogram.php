<?php

namespace Blixter\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $histogram = "";
        $rollSerie = $this->getSerie();
        $min = $this->min;
        $max = $this->max;

        for ($i = $min; $i <=  $max; $i++) {
            // Add lowest and highest numbers to the string.
            // This will also print out empty values
            $histogramrow = "";
            foreach ($rollSerie as $value) {
                if ($value == $i) {
                    $histogramrow = $histogramrow . "*";
                }
            }
            // Returns a string with the roll values
            $histogram = $histogram . $i . ": ";
            $histogram = $histogram . $histogramrow;
            $histogram = $histogram . "\n";
        }
        return $histogram;
    }

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
