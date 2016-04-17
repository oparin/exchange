<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 1/22/16
 * Time: 5:07 PM
 */

namespace Admin\ArbitrageBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class ArbitrageStatusColumn
 * @package Admin\ArbitrageBundle\Grid\Column
 */
class ArbitrageStatusColumn extends Column
{
    /**
     * @param array $params
     */
    public function __initialize(array $params)
    {
        parent::__initialize($params);

        // Disable the filter of the column
//        $this->setFilterable(false);
        $this->setOrder(false);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'arbitrage_status';
    }
}
