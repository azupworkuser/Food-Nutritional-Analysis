<template>
  <v-container fluid>
    <v-card-text
    >
      <v-row align="center">
        <v-col
          class="d-flex"
          cols="12"
          sm="3"
        >
          <v-text-field
            :loading="loading"
            variant="solo"
            label="Search Fruit"
            append-inner-icon="mdi-magnify"
            v-model="search"
          ></v-text-field>
        </v-col>

        <v-col
          class="d-flex"
          cols="12"
          sm="3"
        >
          <v-select
            :items="families"
            variant="solo"
            v-model="family"
            item-value="id"
            label="Select Family"
          ></v-select>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card>
      <div>
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
            <th class="text-left">
              Favorite
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-if="fruits.length === 0">
            <td colspan="7">
              <center>Records not found</center>
            </td>
          </tr>
          <tr
            v-for="(item, index) in fruits"
            :key="item.id"
          >
            <td>{{ index+1  }}</td>
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
            <td>
              <input type="checkbox" :checked="item.is_favorite === true" @change="toggleFavorite(item.uuid)">
            </td>
          </tr>
          </tbody>
        </v-table>
        <pagination-block :meta="meta" @previousClicks="handlePagination(false)" @nextClicks="handlePagination(true)" />
      </div>
    </v-card>
  </v-container>
</template>

<script>
import {getFruits, getFamilies, toggleFavorite} from "@/services/ApiHelper";
import NutritionBlock from "@/components/NutritionBlock"
import PaginationBlock from "@/components/PaginationBlock"

export default {
  name: 'ListPage',
  components: {
    NutritionBlock,
    PaginationBlock,
  },
  data () {
    return {
      families: [],
      fruits: [],
      loading: true,
      search: null,
      family: null,
      meta: {
        limit: 10,
        page: 1,
        total: 0
      }
    }
  },
  watch:{
    search(value) {
      this.search = value;
      this.getFruitsFromApi();
    },
    family(value) {
      this.family = value;
      this.getFruitsFromApi();
    }
  },
  created() {
    this.getFruitsFromApi();
    this.getFruitsFamily()
  },
  methods: {
    handlePagination(isNext) {
      if (isNext) {
        this.meta.page += 1;
      } else {
        this.meta.page -= 1;
      }
      this.getFruitsFromApi()
    },
    toggleFavorite(uuid) {
      toggleFavorite(uuid).then((data) => {
        console.log(data);
      });
    },
    getFruitsFromApi() {
      this.loading = true
      let param = {
        "limit": this.meta.limit,
        "page": this.meta.page
      }

      if (this.family) {
        param.family = this.family;
      }

      if (this.search) {
        param.query = this.search;
      }

      getFruits(param)
        .then(({data, meta}) => {
          this.fruits = data;
          this.meta = meta;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },

    getFruitsFamily() {
      getFamilies()
        .then((data) => {
          this.families = data.map((el) => {
            return {'id': el.uuid, 'title': el.name};
          });
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    }
  }
}
</script>
