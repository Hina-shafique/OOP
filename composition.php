<?php

//simple class method
class Subscription
{
    use Billable;

    protected StripeBillingPortal $stripeBillingPortal;

    public function __construct(StripeBillingPortal $stripeBillingPortal)
    {
        $this->stripeBillingPortal = $stripeBillingPortal;
    }

    public function create()
    {
        return $this->stripeBillingPortal->getCustomer();
    }
    
}

//use inheritance

class billingSubscription extends Subscription
{
    protected function getStripeCustomer()
    {
        //
    }

    protected function getStripeSubscription()
    {
        //
    }
    // it limit access to billing method due to visibility
}

//use traits

trait Billable
{
    protected function getStripeCustomer()
    {
        //
    }

    protected function getStripeSubscription()
    {
        //
    }
    //use in subscription class
}

//use composition

// class StripeBillingPortal //get a dedicated class
// {
//     public function getCustomer()
//     {
//         //
//     }

//     public function getSubscription()
//     {
//         //
//     }
// }

//Dependency injection and abstraction

interface BillingPortal {
    public function getCustomer();
    public function getSubscription();
}

class StripeBillingPortal implements BillingPortal {
    public function getCustomer() { /* ... */ }
    public function getSubscription() { /* ... */ }
}
// use in subscription class like a constructer