<template>
    <v-container fluid style="height: 100%">
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="5"
            >
                <div>Meal</div>
            </v-col>

            <v-col
                cols="12"
                sm="7"
            >
                <div>{{Number(mealValue) === 1 ? 'breakfast' : (Number(mealValue) === 1 ? 'lunch' : 'dinner') }}</div>
            </v-col>
        </v-row>
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="5"
            >
                <div>No. of. People</div>
            </v-col>

            <v-col
                cols="12"
                sm="7"
            >
                <div>{{numberPeople}}</div>
            </v-col>
        </v-row>
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="5"
            >
                <div>Restaurant</div>
            </v-col>

            <v-col
                cols="12"
                sm="7"
            >
                <div>{{restaurantValue}}</div>
            </v-col>
        </v-row>
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="5"
            >
                <div>Dishes</div>
            </v-col>

            <v-col
                cols="12"
                sm="7"
            >
                <div style="width: 100%; height: 150px; border: 1px solid grey; border-radius: 5px; overflow: auto">
                    <div v-for="(item, index) in dishesValue" style="display: flex; justify-content: space-evenly">
                        <div style="margin-bottom: 10px">{{item}}</div>
                        -
                        <div style="margin-bottom: 10px">{{arrNumberServings[index]}}</div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Step4",
    props: ['mealValue', 'numberPeople', 'restaurantValue', 'dishesValue', 'arrNumberServings']
}
</script>

<style scoped>

</style>
