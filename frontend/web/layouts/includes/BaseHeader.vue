<template>
  <v-app-bar
    elevation="0"
    app
    height="90"
    class="align-baseline justify-sm-center align-content-center"
  >
    <v-btn icon class="ml-5 burger-btn">
      <v-img
        max-width="64"
        max-height="49"
        lazy-src="/Burger.svg"
        src="/Burger.svg"
        class="rounded-lg rounded-r-0"
        width="100%"
      ></v-img>
    </v-btn>
    <v-btn icon class="ml-5 logo">
      <v-img
        max-width="64"
        max-height="49"
        lazy-src="/logo.svg"
        src="/logo.svg"
        class="rounded-lg rounded-r-0"
        width="100%"
      ></v-img>
    </v-btn>

    <v-spacer />
    <div class="form__container">
      <small-search-form
        v-if="search"
        class="align-content-center"
        short
      ></small-search-form>
    </div>

    <v-spacer />
    <v-btn
      filled
      solo
      depressed
      raised
      outlined
      class="mr-md-2 btn__header text-capitalize"
      color="#00ACA2"
      >Вход</v-btn
    >
    <v-btn
      class="btn__header text-capitalize"
      color="#00ACA2"
      filled
      solo
      depressed
      raised
      outlined
      >Регистрация</v-btn
    >
  </v-app-bar>
</template>

<script>
import { mdiBiohazard } from '@mdi/js'
import { mapGetters } from 'vuex'
import SmallSearchForm from '../../components/forms/search/SmallSearchForm'

export default {
  name: 'BaseHeader',
  components: { SmallSearchForm },
  props: {
    search: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    logo: mdiBiohazard,
    title: 'Понаехали!',
    drawer: false,
  }),
  computed: {
    ...mapGetters({}),
  },
  methods: {},
}
</script>

<style scoped></style>
