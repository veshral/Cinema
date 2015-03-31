<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

<div class="page-header">
	<h1><i class="fa fa-shopping-cart-large page-header-icon"></i>Récapitulatif de commande</h1>
</div>


<table class="table table-bordered table-success">
            <thead>
            <th>Image</th>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Sous total</th>
            <th>Action</th>
            </thead>
            <tbody>
                <?php foreach ($panier as $items){ ?>
                    <tr>
                        <td>
                            <div class="thumbnail">
                                    <img style="width: 50px" src="<?php echo $items['image']; ?>" />
                            </div>
                        </td>
                        <td>
                            <?php echo $items['title']; ?>

                        </td>
                        <td>
                            <a class="btn btn-dark btn-info" href="<?php echo site_url('movie/diminuer/'.$items['id']); ?>"><span class="fa fa-minus"></span></a>
                            <?php echo $items['quantity']; ?>
                            <a href="<?php echo site_url('movie/augmenter/'.$items['id']); ?>" class="btn btn-dark btn-info"><span class="fa fa-plus"></span></a>
                        </td>

                        <td style="text-align:right"><?php echo price($items['price']); ?></td>
                        <td style="text-align:right"><?php echo price($items['price']); ?></td>
                        <td>
                            <a class="btn btn-dark btn-info" href="<?php echo site_url('movie/removecart/'.$items['id']) ?>"><span class="fa fa-trash-o"></span></a>
                        </td>

                    </tr>

                <?php }; ?>
            <tr>
                <td colspan="4"> </td>
                <td><h3><strong><Total</strong> <?php echo $this->panier->getTotal(); ?>€</h3></td>
                <td><h3><strong>Total TTC <i>(TVA 20%)</i><br /> </strong> <?php echo $this->panier->getTotalTTC(); ?>€</h3></td>
            </tr>
            </tbody>
        </table>


        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

                    <input type="hidden" name="item_name" value="Recapilatif de votre commande">
                    <input type="hidden" name="business" value="julie@meetserious.com">

                    <input type="hidden" name="item_number" value="1">
                    <input type="hidden" name="amount" value="<?php echo $this->panier->getTotalTTC(); ?>">

                    <INPUT TYPE="hidden" NAME="currency_code" value="EUR">
                    <INPUT TYPE="hidden" NAME="shipping" value="0.00">
                    <INPUT TYPE="hidden" NAME="tax" value="0">

                    <input type="hidden" name="first_name" value="Julien">
                    <input type="hidden" name="last_name" value="Boyer">
                    <input type="hidden" name="address1" value="14 Rue Mandar">
                    <input type="hidden" name="city" value="Paris">
                    <input type="hidden" name="state" value="FR">
                    <input type="hidden" name="zip" value="75002">
                    <input type="hidden" name="email" value="juju@meetserious.com">


                    <INPUT TYPE="hidden" NAME="return" value="<?php echo site_url("movie/recapitulatif"); ?>" />
                    <INPUT TYPE="hidden" NAME="cancel_return" value="<?php echo site_url("movie/recapitulatif"); ?>">
                    <INPUT TYPE="hidden" NAME="notify_return" value="<?php echo site_url("movie/checkpayment"); ?>">

                    <!-- Saved buttons use the "secure click" command -->
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="lc" value="FR">
                    <input type="hidden" name="bn" value="PP-BuyNowBF">

                    <!-- Saved buttons are identified by their button IDs -->
                    <input type="hidden" name="hosted_button_id" value="221">

                    <!-- Saved buttons display an appropriate button image. -->
                    <input style="width: 150px" type="image" name="submit" border="0"
                           src="http://www.jewanda-magazine.com/wp-content/uploads/2014/06/paypal-afrique-jewanda.png"
                           alt="PayPal - The safer, easier way to pay online">
                    
                    <img class="pull-right" style="width: 150px" alt="" border="0" width="1" height="1"
                         src="http://www.jewanda-magazine.com/wp-content/uploads/2014/06/paypal-afrique-jewanda.png" >

                </form>




</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>