<template>
    <div style="padding: 100px 300px">
        <v-stepper v-model="e1">
            <v-stepper-header>
                <v-stepper-step
                    :complete="e1 > 1"
                    step="1"
                    editable
                >
                    Step 1
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step
                    :complete="e1 > 2"
                    step="2"
                    :editable="checkStatusStep2()"
                >
                    Step 2
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step
                    :complete="e1 > 3"
                    step="3"
                    :editable="checkStatusStep3()"
                >
                    Step 3
                </v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step
                    :complete="e1 > 4"
                    step="4"
                    :editable="checkStatusStep4()"
                >
                    Review
                </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-card
                        class="mb-12"
                        color="grey lighten-1"
                        height="200px"
                    >
                        <step1
                            @update-meal-value="updateMealValue"
                            @update-number-people="updateNumberPeople"
                        />
                    </v-card>

                    <v-btn
                        color="primary"
                        style="float: right"
                        :disabled="!mealValue || !numberPeople.length || numberPeople > 10"
                        @click="nextStep2"
                    >
                        Continue
                    </v-btn>
                </v-stepper-content>

                <v-stepper-content step="2">
                    <v-card
                        class="mb-12"
                        color="grey lighten-1"
                        height="200px"
                    >
                        <step2
                            ref="step2"
                            @update-restaurant-value="updateRestaurantValue"
                        />
                    </v-card>

                    <v-btn
                        color="primary"
                        style="float: right"
                        :disabled="!restaurantValue"
                        @click="nextStep3"
                    >
                        Continue
                    </v-btn>
                </v-stepper-content>

                <v-stepper-content step="3">
                    <v-card
                        class="mb-12"
                        color="grey lighten-1"
                        height="400px"
                    >
                        <step3
                            ref="step3"
                            :numberPeople="numberPeople"
                            @update-dishes-value="updateDishesValue"
                            @update-total-serving="updateTotalServings"
                        />
                    </v-card>

                    <div v-if="servingValidated" style="color: red; float: left">
                        {{servingTextValidated}}
                    </div>

                    <v-btn
                        color="primary"
                        style="float: right"
                        :disabled="validateStep3()"
                        @click="nextStep4"
                    >
                        Continue
                    </v-btn>
                </v-stepper-content>

                <v-stepper-content step="4">
                    <v-card
                        class="mb-12"
                        color="grey lighten-1"
                        height="400px"
                    >
                        <step4
                            :mealValue="mealValue"
                            :numberPeople="numberPeople"
                            :restaurantValue="restaurantValue"
                            :dishesValue="dishesValue"
                            :arrNumberServings="arrNumberServings"
                        />
                    </v-card>

                    <v-btn
                        color="primary"
                        style="float: right"
                        @click="submitBook"
                    >
                        Submit
                    </v-btn>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
</template>

<script>
import Step1 from './Step1.vue'
import Step2 from "./Step2.vue";
import {toArray} from "lodash/lang";
import Step3 from "./Step3.vue";
import Step4 from "./Step4.vue";

export default {
        components: {Step4, Step3, Step2, Step1},
        data () {
            return {
                e1: 1,
                mealValue: '',
                numberPeople: 0,
                restaurantValue: '',
                listRestaurant: [],
                dishesValue: [''],
                listDishes: [],
                servingValidated: false,
                servingTextValidated: '',
                totalServings: 0,
                arrNumberServings: []
            }
        },
        watch: {
            totalServings(val) {
                if (val > 10) {
                    this.servingValidated = true
                    this.servingTextValidated = "Không được quá 10 suất ăn"
                } else if (val < this.numberPeople) {
                    this.servingValidated = true
                    this.servingTextValidated = "Số suất ăn phải lớn hơn hoặc bằng " + this.numberPeople + " phần"
                } else {
                    this.servingValidated = false
                }
            }
        },
        methods: {
            toArray,
            updateMealValue(val) {
                this.mealValue = val
            },
            updateNumberPeople(val) {
                this.numberPeople = val
            },
            updateRestaurantValue(val) {
                this.restaurantValue = val
            },
            updateDishesValue(val) {
                this.dishesValue = val
            },
            updateTotalServings(val, val2) {
                this.totalServings = val
                this.arrNumberServings = val2
            },
            checkStatusStep2() {
                return !(!this.listRestaurant.length)
            },
            checkStatusStep3() {
                return !(!this.listDishes.length)
            },
            checkStatusStep4() {
                return !(!this.mealValue) && (this.numberPeople > 0 && this.numberPeople <= 10) && !(!this.restaurantValue) && this.dishesValue.includes('') && this.servingValidated
            },
            getRestaurant() {
                new Promise((resolve, reject) => {
                    axios({
                        url: 'api/get-restaurant?mealSelected=' + this.mealValue,
                        method: 'GET',
                    })
                        .then((resp) => {
                            this.listRestaurant = toArray(resp.data)
                            resolve(resp.data)
                        })
                        .catch((err) => {
                            console.log(err)
                            reject(err)
                        }).finally(() => {
                        this.$refs.step2.getData(this.restaurantValue, this.listRestaurant)
                    })
                })
            },
            getDishes() {
                new Promise((resolve, reject) => {
                    axios({
                        url: 'api/get-dishes?restaurantSelected=' + this.restaurantValue + '&mealSelected=' + this.mealValue,
                        method: 'GET',
                    })
                        .then((resp) => {
                            this.listDishes = toArray(resp.data)
                            resolve(resp.data)
                        })
                        .catch((err) => {
                            console.log(err)
                            reject(err)
                        }).finally(() => {
                            this.dishesValue = ['']
                            this.$refs.step3.getData(this.dishesValue, this.listDishes)
                        })
                })
            },
            async nextStep2() {
                await this.getRestaurant()
                this.e1 = 2
            },
            async nextStep3() {
                await this.getDishes()
                this.e1 = 3
            }
            ,
            async nextStep4() {
                this.e1 = 4
            },
            validateStep3() {
                const statusDish = this.dishesValue.includes('')

                return statusDish || this.servingValidated
            },
            submitBook() {
                console.log(this.mealValue)
                console.log(this.numberPeople)
                console.log(this.restaurantValue)
                console.log(this.dishesValue)
                console.log(this.arrNumberServings)
            }
        }
    }
</script>
