<?php
class Formatter extends CFormatter
{
    /**
     * @var array the format used to format a number with PHP number_format() function.
     * Three elements may be specified: "decimals", "decimalSeparator" and 
     * "thousandSeparator". They correspond to the number of digits after 
     * the decimal point, the character displayed as the decimal point,
     * and the thousands separator character.
    */
    public $numberFormat=array('decimals'=>0, 'decimalSeparator'=>',', 'thousandSeparator'=>'.');

    /**
     * @var string el formato usado para dar formato a una fecha usando la función date() de PHP.
    */
    public $dateFormat='d/m/Y';
 
    /**
     * Formats the value as a number using PHP number_format() function.
     * new: if the given $value is null/empty, return null/empty string
     * @param mixed $value the value to be formatted
     * @return string the formatted result
     * @see numberFormat
     */
    public function formatNumber($value) {
        if($value === null) return null;    // new
        if($value === '') return '';        // new
        return number_format($value, $this->numberFormat['decimals'], $this->numberFormat['decimalSeparator'], $this->numberFormat['thousandSeparator']);
        }
 
    /*
     * new function unformatNumber():
     * turns the given formatted number (string) into a float
     * @param string $formatted_number A formatted number 
     * (usually formatted with the formatNumber() function)
     * @return float the 'unformatted' number
     */
    public function unformatNumber($formatted_number) {
        if($formatted_number === null) return null;
        if($formatted_number === '') return '';
        if(is_float($formatted_number)) return $formatted_number; // only 'unformat' if parameter is not float already
 
        $value = str_replace($this->numberFormat['thousandSeparator'], '', $formatted_number);
        $value = str_replace($this->numberFormat['decimalSeparator'], '.', $value);
        return (float) $value;
    }

    /**
     * Dar formato a la fecha
     * @param date $value el valor a dar formato
     * @return string el formato resultante
     * @see dateFormat
    */
    public function formatDate($value)
    {
        if($value === null) return null;    // new
        if($value === '') return '';        // new
        return date($this->dateFormat,$value);
    }
}
?>