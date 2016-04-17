<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/18/16
 * Time: 11:45 AM
 */

namespace StatisticBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class TransactionColumn
 * @package StatisticBundle\Grid\Column
 */
class TransactionColumn extends Column
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
        return 'transaction';
    }
}
