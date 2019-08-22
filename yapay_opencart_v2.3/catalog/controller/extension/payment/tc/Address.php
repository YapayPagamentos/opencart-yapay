<?php
/**
* 2017 Yapay
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Igor Cicotoste <ifredi@tray.net.br>
*  @copyright  Yapay
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Address
{
    
	private $completion = array("casa", "ap", "apto", "apart", "frente", "fundos", "sala", "cj");
	private $df 		= array("bloco", "setor", "quadra", "lote");
	private $noDf 		= array("av", "avenida", "rua", "alameda", "al.", "travessa", "trv", "praça", "praca");
	private $without 		= array("sem ", "s.", "s/", "s. ", "s/ ");
	private $number 	= array('n.º', 'nº', "numero", "num", "número", "núm", "n");
	
	/**
	 * getAddress
	 * @param string $address 
	 * @return array
	 */
    public function getAddress($address) {
        $street = ""; $number = ""; $completion = "";
        if ($this->isDf($address)) {
          $number = 's/nº';
          list($street, $completion) = $this->partCompletion($address);
        } else {
          $splited = preg_split('/[-,]/', $address);
          if (in_array(sizeof($splited), array(2, 3))) { 
            //var_dump($splited);
            //var_dump(sizeof($splited));
            //list($street, $number, $completion) = $splited;
            if (sizeof($splited) == 3){
                list($street, $number, $completion) = $splited;
            }else{
                list($street, $number) = $splited;
            }
          } else {
            list($street, $number) = $this->reverse($address);
          }
          $street = $this->cleanNumber($street);
          if (strlen($completion)==0)
            list($numberb,$completion) = $this->partNumber($number);
        }
        return array($this->endtrim($street), $this->endtrim($number), $this->endtrim($completion));
    }
	
	/**
	 * partNumber
	 * @param string $n
	 * @return array
	 */
    public function partNumber($n) {
        $withoutNumber = $this->withoutNumber();
        $n = $this->endtrim($n);
        foreach ($withoutNumber as $sn) {
          if ($n == $sn)return array($n, '');
          if (substr($n, 0, strlen($sn)) == $sn)
            return array(substr($n, 0, strlen($sn)), substr($n, strlen($sn)));
        }
        $q = preg_split('/\D/', $n);
        $pos = strlen($q[0]);
        return array(substr($n, 0, $pos), substr($n,$pos));
    }
    
	/**
	 * partCompletion
	 * @param string $address   
	 * @return array
	 */
    function partCompletion($address) {
        foreach ($this->$completion as $c)
          if ($pos = strpos(strtolower($address), $c))
            return array(substr($address, 0 ,$pos), substr($address, $pos));
        return array($address, '');
    }
    
	/**
	 * @param string
	 * @return string
	 */
    function endtrim($e){
        return preg_replace('/^\W+|\W+$/', '', $e);
    }
	
	/**
	 * cleanNumber
	 * @param string $street   Endereço a ser tratado
	 * @return string
	 */
    function cleanNumber($street) {
        foreach ($this->number as $n)
          foreach (array(" $n"," $n ") as $N)
          if (substr($street, -strlen($N)) == $N)
            return substr($street, 0, -strlen($N));
        return $street;
    }
    
	/**
	 * @param string $address
	 * @return array
	 */
    function reverse($address) {
        $find = substr($address, -10);
        for ($i = 0; $i < 10; $i++) {
        	if (is_numeric(substr($find, $i, 1))) {
				return array( substr($address, 0, -10+$i), substr($address, -10+$i) );
			}
        }
    }
    
	/**
	 * @param string $address 
	 * @return bool
	 */
    function isDf($address) {
        $df = false;
        foreach ($this->df as $b)
        	if (strpos(strtolower($address),$b) != false)
            	$df = true;
        if ($df)
			foreach ($this->noDf as $b)
				if (strpos(strtolower($address),$b) != false)
					$df = false;
        return $df;
    }

	/**
	 * @return array
	 */
    function withoutNumber() {
        foreach ($this->number as $n)
        	foreach ($this->without as $s)
            	$withoutNum[] = "$s$n";
        return $withoutNum;
    }
    
}