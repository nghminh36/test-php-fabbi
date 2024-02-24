<template>
    <v-container fluid>
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="6"
            >
                <span>Chọn nhà hàng</span>
                <v-select
                    v-model="restaurantValue"
                    item-value="restaurant"
                    item-text="restaurant"
                    outlined
                    style="margin-top: 10px"
                    :rules="[(v) => !!v || 'Không được để trống']"
                    :items="listRestaurant"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>

export default {
    name: "Step2",
    data: () => ({
        restaurantValue: '',
        listRestaurant: []
    }),
    watch: {
        restaurantValue(val) {
            this.$emit('update-restaurant-value', val)
        }
    },
    methods: {
        getData(restaurantValue, listRestaurant) {
            this.restaurantValue = restaurantValue
            this.listRestaurant = listRestaurant
        }
    }
}
</script>

<style scoped>

</style>
