<script>
import { RouterLink } from 'vue-router';
import { store } from '../../../store';

export default {
    props: {
        company: Object,
        cartDishes: Array,
    },

    data() {
        return {
            store,
        }
    },


    methods: {
        getPrice(qty, price) {

            const total = (qty * price).toFixed(2);

            return total
        },

        getTotal() {

            let sum = 0;

            this.cartDishes.forEach(element => {



                const dishPrice = element.price * element.qty


                sum += dishPrice

            });

            sum = sum.toFixed(2);
            
            return sum
        },

        ereaseAllDishFromCart(){
            this.store.showClearCart = true;
            this.store.clearAllCart = true;
            this.store.clearCartMessage = 'Vuoi davvero svuotare il carrello?';

        },

        hideClearCart() {
            this.store.showClearCart = false;
            this.store.clearAllCart = false;
        },
    }
}
</script>

<template>
    <div class="cart-component">
        <div class="card">
            <div class="card-header">

                <div v-if="store.cartCompany !== null" class="d-flex flex-column">
                    <span>Stai acquistando presso:</span>
                    <span class="company-name">{{ store.cartCompany.name }}</span>
                </div>
                <p v-else>
                    Nessuna compagnia selezionata.
                </p>
            </div>
            <div class="card-body">

                <div class="row mb-2 pe-2" v-for="(dish, i) in cartDishes">
                    <div class="col-2 d-flex gap-2">
                        <span class="my-cart-btn" @click="$emit('decrease', dish.id)">-</span>
                        <input type="hidden" class="w-25" :value="dish.qty">
                        <span class="">{{ dish.qty }}</span>
                        <span class="my-cart-btn" @click="$emit('increase', dish.id)">+</span>
                    </div>
                    <div class="col-5 text-start">
                        <p>{{ dish.name }}</p>
                    </div>
                    <div class="col-4">
                        <p>{{ getPrice(dish.qty, dish.price) }} €</p>
                    </div>
                    
                    <div class="col-1">
                        <span @click="$emit('remove', i)"><font-awesome-icon class="cart-trash"
                                :icon="['far', 'trash-can']" /></span>
                    </div>

                </div>
                <div class="row mb-2 text-center">
                    <p class="cart-order">Totale Ordine:</p>
                    <p class="cart-total">{{ getTotal() }} €</p>
                </div>


                <div class="card-fooder d-flex justify-content-center pe-2 pb-2 gap-3"
                    v-if="store.cartDishes.length > 0">
                    <RouterLink class="btn btn-outline-blue" :to="{ name: 'payment' }">
                        Procedi al Pagamento
                    </RouterLink>
                    <span class="btn btn-outline-danger d-flex align-items-center" @click="ereaseAllDishFromCart">Svuota</span>
                </div>
                <div class="card-fooder d-flex justify-content-center pe-2 pb-2 gap-3" v-else>
                    <p class="btn btn-outline-coral fake-pay">
                        Carrello Vuoto
                    </p>
                </div>


                <div class="my-cart-alert" v-show="store.showClearCart === true">
                    <p>
                        {{ store.clearCartMessage }}
                    </p>
                    <h5>
                        <span class="my-cart-alert__yes" @click="$emit('newPurchase')">Sì</span> <span
                            class="my-cart-alert__no" @click="hideClearCart">No
                        </span>
                    </h5>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss" scoped>
@use '../../../assets/style/partials/variables.scss' as *;

.my-cart-alert {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 101%;
    margin-left: -1px;
    background-color: white;
    color: $app-brand-blue;
    display: flex;
    flex-direction: column;
    justify-content: space-around;

    .my-cart-alert__no,
    .my-cart-alert__yes {
        cursor: pointer;
        padding: 3px 5px;
    }

    .my-cart-alert__yes {
        margin-right: 55px;
        color: red;

        &:hover {
            color: rgb(218, 136, 136)
        }
    }

    .my-cart-alert__no {
        color: green;

        &:hover {
            color: rgb(144, 214, 144)
        }
    }
}

.cart-component {

    font-weight: 100;


    .my-cart-btn {
        color: $app-brand-blue;
        cursor: pointer;

        &:hover {
            color: $app-brand-yellow;
        }
    }

    .card-header {
        color: white;
        background-color: $app-brand-blue;
        border: 6px solid $app-brand-blue;
        margin: -3px;
    }

    .company-name {
        font-size: 24px;
    }

    .cart-order {
        font-size: 20px;
    }

    .cart-total {
        font-size: 36px;
        color: $app-brand-red;
    }

    .cart-trash {
        padding: 0 5px;

        &:hover {
            color: red;
            cursor: pointer;
        }
    }
}

.fake-pay {
    pointer-events: none;
    cursor: not-allowed;
    // background-color: $app-brand-yellow;
    // color: $app-brand-blue;
}
</style>