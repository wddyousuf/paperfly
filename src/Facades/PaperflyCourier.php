<?php
namespace Wddyousuf\Paperfly\Facades;
use Illuminate\Support\Facades\Facade;


/**
 * @method static Wddyousuf\Paperfly\Provider\PaperflyCourier sendRequest(array $orderInformation=[])
 * @method static Wddyousuf\Paperfly\Provider\PaperflyCourier trackOrder(array $orderId)
 * @method static Wddyousuf\Paperfly\Provider\PaperflyCourier courierInvoice(array $orderId)
 * @method static Wddyousuf\Paperfly\Provider\PaperflyCourier CourierOrderCancel(array $orderId)
 *
 * @see \Wddyousuf\Paperfly\Provider\PaperflyCourier
 */
class PaperflyCourier extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PaperflyCourier';
    }
}
