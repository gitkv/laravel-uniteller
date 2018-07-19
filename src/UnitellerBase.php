<?php

namespace gitkv\Uniteller;

use Tmconsulting\Uniteller\Cancel\CancelBuilder;
use Tmconsulting\Uniteller\Client;
use Tmconsulting\Uniteller\Order\Order;
use Tmconsulting\Uniteller\Payment\PaymentBuilder;
use Tmconsulting\Uniteller\Recurrent\RecurrentBuilder;


/**
 * Class UnitellerBase
 * @package gitkv\Uniteller
 */
class UnitellerBase {

    /**
     * @var null|Client
     * @var null|string
     * @var null|string
     */
    private
        $uniteller = null,
        $successUrl = null,
        $failureUrl = null;

    /**
     * UnitellerBase constructor.
     * @param string $shopId
     * @param string $login
     * @param string $password
     * @param string $baseUrl
     * @param string $successUrl
     * @param string $failureUrl
     */
    public function __construct(string $shopId, string $login, string $password, string $baseUrl, string $successUrl, string $failureUrl) {
        $this->uniteller = new Client();
        $this->uniteller->setShopId($shopId);
        $this->uniteller->setLogin($login);
        $this->uniteller->setPassword($password);
        $this->uniteller->setBaseUri($baseUrl);
        $this->successUrl = $successUrl;
        $this->failureUrl = $failureUrl;
    }

    /**
     * @param PaymentBuilder $builder
     * @param bool $getUrl
     * @return string|void
     */
    public function pay(PaymentBuilder $builder, bool $getUrl = true) {
        if (!$builder->getUrlReturnOk())
            $builder->setUrlReturnOk($this->successUrl);
        if (!$builder->getUrlReturnNo())
            $builder->setUrlReturnNo($this->failureUrl);
        $payment = $this->uniteller->payment($builder);

        return $getUrl ? $payment->getUri() : $payment->go();
    }

    /**
     * @param RecurrentBuilder $builder
     * @return Order
     */
    public function recurrentPay(RecurrentBuilder $builder) {
        return $this->uniteller->recurrent($builder);
    }

    /**
     * @param string $orderIdp
     * @return Order|null
     */
    public function receiveResult(string $orderIdp) {
        $results = $this->uniteller->results([
            'ShopOrderNumber' => $orderIdp,
        ]);

        return $results[0] ?? null;
    }

    /**
     * @param string $signature
     * @param array $postParams
     * @return bool
     */
    public function verifySignature(string $signature, array $postParams) {
        return $this->uniteller->getSignaturePayment()->verify($signature, $postParams);
    }

    /**
     * @param CancelBuilder $builder
     * @return mixed
     */
    public function cancel(CancelBuilder $builder) {
        return $this->uniteller->cancel($builder);
    }
}
