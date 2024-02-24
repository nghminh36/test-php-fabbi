<template>
    <v-container fluid style="overflow: auto; height: 100%">
        <v-row
            v-for="(dishValue, index) in dishesValue"
            :key="index"
            style="padding-top: 20px"
        >
            <v-col
                cols="12"
                sm="9"
            >
                <span>Chọn món ăn</span>
                <v-select
                    v-model="dishesValue[index]"
                    item-value="name"
                    item-text="name"
                    outlined
                    style="margin-top: 10px"
                    :rules="[(v) => !!v || 'Không được để trống']"
                    :items="arrListDishes[index]"
                    @change="changeListDishes(dishesValue, dishesValue[index], listDishes, index); updatePreviousValue(index, dishesValue[index], arrListDishes[index])"
                />
            </v-col>
            <v-col
                cols="12"
                sm="3"
            >
                <span>Chọn số suất ăn</span>
                <v-text-field
                    v-model="arrNumberServings[index]"
                    single-line
                    outlined
                    type="number"
                    min="1"
                    max="10"
                    :rules="[(v) => !!v || 'Không được để trống']"
                    style="margin-top: 10px"
                />
            </v-col>
        </v-row>
        <v-btn
            v-if="totalServings < 10"
            color="primary"
            fab
            dark
            small
            @click="addItem"
        >
            <span style="font-size: 25px; margin-bottom: 5px">+</span>
        </v-btn>
    </v-container>
</template>

<script>
export default {
    name: "Step3",
    props: ['numberPeople'],
    data: () => ({
        dishesValue: [''],
        listDishes: [],
        arrListDishes: [],
        previousValue: [],
        arrNumberServings: [],
        maxValue: 10,
        totalServings: 0
    }),
    watch: {
        dishesValue(val) {
            this.$emit('update-dishes-value', val)
        },
        arrNumberServings(val) {
            this.totalServings = val.reduce((total, currentValue) => total + Number(currentValue), 0)
            this.$emit('update-total-serving', this.totalServings, this.arrNumberServings)
        }
    },
    methods: {
        getData(dishesValue, listDishes) {
            this.dishesValue = dishesValue
            this.listDishes = listDishes
            this.arrListDishes=[]
            this.arrListDishes.push(this.listDishes)
            this.arrNumberServings = []
            this.arrNumberServings.push(1)
        },
        addItem() {
            this.dishesValue.push('')
            this.arrListDishes.push(this.listDishes)
            this.arrNumberServings.push(1)
        },
        changeListDishes(valueSelectedArr, valueSelected, listDishes, index) {
            const arrValueSelected = this.dishesValue.filter((obj) => obj !== '').map((item) => item)
            valueSelectedArr.forEach((value, key) => {
                if (key !== index) {
                    if (value) {
                        const arrValueSelectedNotCurrent = this.dishesValue.filter((obj) => obj !== '').filter((obj) => obj !== value).map((item) => item)
                        this.arrListDishes[key] = this.arrListDishes[key].filter((item) => !arrValueSelectedNotCurrent.includes(item.name))
                        if (this.previousValue[index]) {
                            this.arrListDishes[key].push(this.previousValue[index])
                            this.arrListDishes[key].sort((a, b) => a.id - b.id)
                        }
                    } else {
                        this.arrListDishes[key] = listDishes.filter((item) => !arrValueSelected.includes(item.name))
                        if (this.previousValue[index]) {
                            this.arrListDishes[key].push(this.previousValue[index])
                            this.arrListDishes[key].sort((a, b) => a.id - b.id)
                        }
                    }
                } else {
                    if (value) {
                        this.listDishes = listDishes.filter((item) => item.name !== valueSelected)
                        if (this.previousValue[index]) {
                            this.listDishes.push(this.previousValue[index])
                            this.listDishes.sort((a, b) => a.id - b.id)
                        }
                    } else {
                        if (this.previousValue[index]) {
                            this.listDishes.push(this.previousValue[index])
                            this.listDishes.sort((a, b) => a.id - b.id)
                        }
                    }
                }
            })
            this.listDishes = this.listDishes.filter((item) => !arrValueSelected.includes(item.id))
        },
        updatePreviousValue(index, value, arrValueIndex) {
            this.previousValue[index] = arrValueIndex.filter((item) => item.name === value)[0]
        }
    }
}
</script>

<style scoped>

</style>
