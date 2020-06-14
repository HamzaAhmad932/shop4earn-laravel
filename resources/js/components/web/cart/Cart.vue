<template>
    <div>
        <!--shopping cart area start -->
        <div class="shopping_cart_area mt-60">
            <div class="container">
                <form action="#">
                    <div class="row">
                        <div class="col-12">
                            <div class="table_desc">
                                <div class="cart_page table-responsive">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="product in cart_content">
                                                <td class="product_remove"><a href="#" @click="deleteCartItem(product.rowId)"><i class="fa fa-trash-o"></i></a></td>
                                                <td class="product_thumb"><a href="#"><img :src="product.options.image_path" alt=""></a></td>
                                                <td class="product_name"><a href="#">{{product.name}}</a></td>
                                                <td class="product-price">Rs.{{product.price}}</td>
                                                <td class="product_quantity"><label>Quantity</label>
                                                    <input min="0" max="100" v-model="product.qty" type="number" @change="updateQty({row_id: product.rowId, qty: product.qty})" /></td>
                                                <td class="product_total">Rs.{{product.subtotal}}</td>
                                            </tr>
                                            <tr v-if="cart_content.length === 0">
                                                <td colspan="6">Cart is Empty!</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart_submit">
                                    <a href="/">Continue shopping...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--coupon code area start-->
                    <div class="coupon_area">
                        <div class="row">
<!--                            <div class="col-lg-6 col-md-6">-->
<!--                                <div class="coupon_code left">-->
<!--                                    <h3>Coupon</h3>-->
<!--                                    <div class="coupon_inner">-->
<!--                                        <p>Enter your coupon code if you have one.</p>-->
<!--                                        <input placeholder="Coupon code" type="text">-->
<!--                                        <button type="submit">Apply coupon</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-lg-12 col-md-12">
                                <div class="coupon_code right">
                                    <h3>Cart Totals</h3>
                                    <div class="coupon_inner">
                                        <div class="cart_subtotal">
                                            <p>Subtotal</p>
                                            <p class="cart_amount">Rs.{{totals.sub_total}}</p>
                                        </div>
<!--                                        <div class="cart_subtotal ">-->
<!--                                            <p>Shipping</p>-->
<!--                                            <p class="cart_amount"><span>Flat Rate:</span> £255.00</p>-->
<!--                                        </div>-->
<!--                                        <a href="#">Calculate shipping</a>-->

                                        <div class="cart_subtotal">
                                            <p>Total</p>
                                            <p class="cart_amount">Rs.{{totals.total}}</p>
                                        </div>
                                        <div class="checkout_btn">
                                            <a href="/checkout">Proceed to Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--coupon code area end-->
                </form>
            </div>
        </div>
        <!--shopping cart area end -->
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        mounted() {
            this.getCartContent();
        },
        methods: {
            ...mapActions([
                'getCartContent',
                'updateQty',
                'deleteCartItem'
            ])
        },

        computed: {
            ...mapState({
                cart_content: function (state) {
                    return state.cart.cart_content;
                },
                totals: function (state) {
                    return state.cart.totals;
                },
            })
        }
    }
</script>
<style scoped>
    .cart_submit a {
        background: #000000;
        border: 0;
        color: #ffffff;
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
        height: 38px;
        line-height: 18px;
        padding: 10px 15px;
        text-transform: uppercase;
        cursor: pointer;
        -webkit-transition: 0.3s;
        transition: 0.3s;
        border-radius: 3px;
    }
</style>
