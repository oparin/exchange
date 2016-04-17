<?php
/**
 * Created by PhpStorm.
 * User: oparin
 * Date: 7/25/15
 * Time: 5:04 PM
 */

namespace Admin\SupportBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class TicketStatusColumn
 * @package Admin\SupportBundle\Grid\Column
 */
class TicketStatusColumn extends Column
{
//    /**
//     * @param array $params
//     */
//    public function __initialize(array $params)
//    {
//        parent::__initialize($params);
//
//        // Disable the filter of the column
//        $this->setFilterable(true);
//        $this->setOrder(false);
//    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'support_ticket_status';
    }
}
