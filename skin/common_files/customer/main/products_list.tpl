{*
$Id: products_list.tpl,v 1.4.2.7 2012/02/20 11:48:04 aim Exp $
vim: set ts=2 sw=2 sts=2 et:
*}


<div class="quick-order-box quick-order-box-bottom">
 <div class="quick-order-box-title"><input type="hidden" id="ajax_load_part" name="ajax_load_part" value="1"></div>
 <div class="quick-order-box-container">
<div class="quick-order-products">
 <div class="quick-order-products-box">
  <div class="quick-order-products-content quick-order-main-window">
   <div style="display: block;" id="quick-order-main-display"><div class="quick-order-products-return">
 <div class="quick-order-products-list" id="ajax_list" style="height: 1000px; overflow:auto">
 
 {foreach from=$products item=product name=products}               
  <div class="quick-order-product" id="{$product.productid}">
   <div class="quick-order-product-thumb">
    <div class="quick-order-product-thumb-box" style="width: 135px">
     {include file="product_thumbnail.tpl" productid=$product.productid image_x=$product.tmbn_x image_y=$product.tmbn_y product=$product.product tmbn_url=$product.tmbn_url}    </div>
   </div>
   <div class="quick-order-product-data">
    <div class="quick-order-product-box1">
     <div class="quick-order-product-box2">
      <div class="quick-order-product-content1">
       <div class="quick-order-product-content2">
        <div class="quick-order-product-title">{$product.product|amp}</div>
        <div class="quick-order-product-price">
         <span class="quick-order-price-text">
<span class="currency">{currency value=$product.taxed_price}</span>
</span>
        </div>
        <div class="quick-order-product-descr">{$product.descr|amp}</div>
       </div>
      </div>
      <div class="quick-order-product-add">
       <div class="quick-order-product-add-box">
        <div class="quick-order-product-qty"><input name="amount_{$product.productid}" id="amount_{$product.productid}" value="1" type="text"></div>
        <div class="quick-order-product-btn"><input type="button" value="Add" id="quick-add-input" onclick="return cartSubmitAjax('{$product.productid}');" /></div>
        <div class="clearing"></div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <div class="clearing"></div>
  </div>
  <div class="quick-order-product-sep"></div>
{/foreach}

 </div>
</div></div>
  </div>
 </div>
</div>

 </div>
</div>
