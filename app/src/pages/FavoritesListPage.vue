<template>
  <v-container fluid>
    <v-row dense>
      <v-col
        cols="9"
        class="flex-grow-2 flex-shrink-5 pr-5"
      >
        <v-card>
          <v-table>
            <thead>
            <tr>
              <th class="text-left">
                #
              </th>
              <th class="text-left">
                Name
              </th>
              <th class="text-left">
                Family
              </th>
              <th class="text-left">
                Genus
              </th>
              <th class="text-left">
                Order
              </th>
              <th class="text-left">
                Nutritions
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="favoriteFruits.length === 0">
              <td colspan="7">
                <center>Records not found</center>
              </td>
            </tr>
            <tr
              v-for="(item, index) in favoriteFruits"
              :key="item.id"
            >
              <td>{{ index + 1 }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.family.name }}</td>
              <td>{{ item.genus.name }}</td>
              <td>{{ item.order.name }}</td>
              <td>
                <v-chip
                  class="ml-2"
                  color="teal"
                  text-color="white"
                  prepend-icon="mdi-chart-pie"
                >
                  Nutritions
                  <v-tooltip
                    activator="parent"
                    location="end"
                    width="250"
                    height="280"
                  >
                      <nutrition-block :nutritions="item.nutrition" size="small"></nutrition-block>
                  </v-tooltip>
                </v-chip>
              </td>
            </tr>
            </tbody>
          </v-table>
        </v-card>
      </v-col>
      <v-col
        cols="3"
      >
        <nutrition-block :nutritions="totalNutritions" size="large"></nutrition-block>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {getFavoriteFruits} from "@/services/ApiHelper";
import NutritionBlock from "@/components/NutritionBlock"

export default {
  name: 'FavoritesListPage',
  components: {
    NutritionBlock,
  },
  data () {
    return {
      favoriteFruits: [],
      loading: true,
    }
  },
  created() {
    this.loading = true;
    getFavoriteFruits()
      .then((data) => {
        this.favoriteFruits = data;
      })
      .catch((error) => {
        console.error(error);
      })
      .finally(() => {
        this.loading = false;
      });
  },
  computed: {
    totalNutritions() {
      let response = {
        protein: 0,
        carbohydrates: 0,
        fat: 0,
        calories: 0,
        sugar: 0
      }
      this.favoriteFruits.forEach((favoriteFruit) => {
        response.protein += favoriteFruit.nutrition.protein;
        response.carbohydrates += favoriteFruit.nutrition.carbohydrates;
        response.fat += favoriteFruit.nutrition.fat;
        response.calories += favoriteFruit.nutrition.calories;
        response.sugar += favoriteFruit.nutrition.sugar;
      });
      response.protein = response.protein.toFixed(2);
      response.carbohydrates = response.carbohydrates.toFixed(2);
      response.calories = response.calories.toFixed(2);
      response.fat = response.fat.toFixed(2);
      response.sugar = response.sugar.toFixed(2);
      return response;
    }
  },
  methods: {}
}
</script>
