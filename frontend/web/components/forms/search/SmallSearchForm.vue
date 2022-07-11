<template>
  <v-form
    ref="search"
    v-model="valid"
    lazy-validation
    @submit.prevent="submit"
    class="small-search-form d-flex align-center"
  >
    <v-icon dense color="#00ACA2" class="ml-2">mdi-magnify</v-icon>

    <v-row dense class="pa-0 ma-0">
      <v-tooltip
        slot="append"
        v-model="showCityHint"
        :top="!short"
        :bottom="short"
      >
        <template #activator="{}">
          <city-select
            ref="citySelect"
            v-model="city"
            :dense="short"
            @input="onCityChange"
            :has-background="isPageSearch"
            class="small-search-form__city"
          ></city-select>
        </template>
        <v-icon dense color="accent">mdi-home-search</v-icon>
        <span> Выберите пункт назначения </span>
      </v-tooltip>
      <v-divider
        class="mx-3 pt-1 pb-1 small-search__divider"
        inset
        vertical
      ></v-divider>
      <v-menu
        ref="menuDates"
        v-model="menuDates"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        max-width="250px"
        min-width="auto"
      >
        <template #activator="{ on, attrs }">
          <v-text-field
            v-model="formattedDate"
            label="Даты"
            :prepend-icon="short ? '' : 'mdi-calendar'"
            v-bind="attrs"
            filled
            :background-color="isPageSearch ? 'transparent' : ''"
            hide-details
            rounded
            solo
            :dense="short"
            v-on="on"
            class="pa-0 ma-0 small-search-form__date"
          ></v-text-field>
        </template>
        <v-date-picker v-model="dates" solo range filled rounded no-title>
          <v-spacer></v-spacer>
          <v-btn text color="primary" @click="menuDates = false">
            Cancel
          </v-btn>
          <v-btn text color="primary" @click="menuDates = false"> OK </v-btn>
        </v-date-picker>
      </v-menu>
      <v-divider
        class="mx-3 pt-1 pb-1 small-search__divider"
        inset
        vertical
      ></v-divider>
      <v-select
        v-model="currentVisitors"
        :items="visitors"
        :menu-props="{ maxHeight: '400' }"
        hide-details
        solo
        rounded
        filled
        :background-color="isPageSearch ? 'transparent' : ''"
        :dense="short"
        label="Посетители"
        item-text="title"
        item-value="id"
        class="small-search-form__visitors"
      ></v-select>

      <v-col v-if="!short" cols="12" md="1">
        <v-btn color="accent" type="submit" dark fab>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import { mapMutations } from 'vuex'
import CitySelect from '../../controls/selects/CitySelect'

export default {
  name: 'SmallSearchForm',
  components: { CitySelect },

  props: {
    short: {
      type: Boolean,
      default: false,
    },
  },
  data: (vm) => ({
    valid: false,

    dates: [],
    currentVisitors: null,
    city: vm.$route.params.city,
    visitors: [{ id: '1', title: '3 гостя, 1 питомец' }],
    menuDates: false,

    showCityHint: false,
  }),
  computed: {
    isPageSearch() {
      return this.$route.name === 'search-city'
    },
    formattedDate() {
      return this.dates && this.dates[0] && this.dates[1]
        ? `${this.$dayjs(this.dates[0]).format('DD.MM')} - ${this.$dayjs(
            this.dates[1]
          ).format('DD.MM')}`
        : ''
    },
  },

  watch: {},

  methods: {
    ...mapMutations({
      setCurrentCity: 'web/geo/setCity',
    }),
    onCityChange(value) {
      this.showCityHint = false
      this.setCurrentCity(value)
      if (this.short) {
        this.submit()
      }
    },

    submit() {
      if (!this.city) {
        this.showCityHint = true
        this.$refs.citySelect.activateMenu()
        return
      }
      const url = `/search/${this.city}/`
      this.$router.push(url)
    },
  },
}
</script>

<style scoped></style>
