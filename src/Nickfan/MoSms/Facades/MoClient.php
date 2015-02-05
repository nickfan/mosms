<?php
/**
 * Description
 *
 * @project mosms
 * @package 
 * @author nickfan<nickfan81@gmail.com>
 * @link http://www.axiong.me
 * @version $Id$
 * @lastmodified: 2015-02-04 15:20
 *
 */

namespace Nickfan\MoSms\Facades;

use Illuminate\Support\Facades\Facade;

class MoClient extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'moclient';
    }
}