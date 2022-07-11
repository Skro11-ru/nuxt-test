<template>
  <v-container fluid pa-0 class="search__container">
    <v-row class="search__container__row" no-gutters>
      <v-col class="pl-5 pr-5 pt-0 grey lighten-1" cols="12" md="6">
        <v-list class="list-cards pa-0 grey lighten-1">
          <v-list-item v-for="i in 10" :key="i" class="pa-0">
            <object-card></object-card>
          </v-list-item>
        </v-list>
        <div class="text-center mt-6 mb-5">
          <v-pagination
            v-model="page"
            color="#00ACA2"
            :length="4"
            circle
          ></v-pagination>
        </div>
      </v-col>

      <v-col
        cols="0"
        md="6"
        class="flex-column align-end pa-0 search__container__row__map"
      >
        <search-map @update:bounds="updateMapBoundsHandler"></search-map>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'

import ObjectCard from '../../components/cards/ObjectCard'
import SearchMap from '../../components/maps/SearchMap'

export default {
  name: 'SearchPage',
  components: { SearchMap, ObjectCard },
  layout: 'search',
  data() {
    return {
      page: 1,
    }
  },
  computed: {},
  mounted() {
    this.list()
  },
  methods: {
    ...mapActions({
      list: 'web/search/getList',
      map: 'web/search/getPoints',
    }),
    updateMapBoundsHandler(bounds) {
      console.log('updateMapBoundsHandler', bounds)
      this.map(bounds)
    },
  },
}
</script>

<style scoped></style>
