<?php

/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/15/16
 * Time: 12:36 PM
 */

namespace Admin\WalletBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class StatusColumn
 * @package Admin\WalletBundle\Grid\Column
 */
class StatusColumn extends Column
{
    /**
     * @param array $params
     */
    public function __initialize(array $params)
    {
        parent::__initialize($params);

        // Disable the filter of the column
//        $this->setFilterable(false);
//        $this->setOrder(false);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'withdraw_status';
    }
}
