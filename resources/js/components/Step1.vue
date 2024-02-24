<template>
    <v-container fluid>
        <v-row style="padding-top: 20px">
            <v-col
                cols="12"
                sm="9"
            >
                <span>Chọn bữa ăn</span>
                <v-select
                    v-model="mealValue"
                    item-value="id"
                    item-text="name"
                    outlined
                    style="margin-top: 10px"
                    :rules="[(v) => !!v || 'Không được để trống']"
                    :items="listMeal"
                />
            </v-col>

            <v-col
                cols="12"
                sm="3"
            >
                <span>Chọn số người</span>
                <v-text-field
                    v-model="numberPeople"
                    single-line
                    outlined
                    type="number"
                    min="1"
                    max="10"
                    :rules="[numberPeopleRule]"
                    style="margin-top: 10px"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Step1",
    data: () => ({
        mealValue: '',
        listMeal: [],
        numberPeople: 0,
        numberPeopleRule: (val) => {
            if (!val) return 'Không được để trống'

            if (val < 1) return 'Không hợp lệ'

            if (val > 10) return 'Số lượng người tối đa chỉ được 10'

            return true
        },
    }),
    created() {
        this.getMeals()
    },
    watch: {
        mealValue(val) {
            this.$emit('update-meal-value', val)
        },
        numberPeople(val) {
            this.$emit('update-number-people', val)
        }
    },
    methods: {
        getMeals() {
            new Promise((resolve, reject) => {
                axios({
                    url: 'api/get-meals',
                    method: 'GET'
                })
                    .then((resp) => {
                        this.listMeal = resp.data
                        resolve(resp.data)
                    })
                    .catch((err) => {
                        console.log(err)
                        reject(err)
                    })
            })
        }
    }
}
</script>

<style scoped>

</style>
