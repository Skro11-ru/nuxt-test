<template>
  <v-card
    v-if="orientation == 'horizontal'"
    width="100%"
    class="object-card object-card_orientation_horizontal rounded-lg elevation-1 w-100"
  >
    <v-container class="w-100">
      <v-row>
        <v-col cols="6" md="6" xl="5" class="pb-0 pa-0">
          <v-img
            height="100%"
            lazy-src="/1.jpg"
            src="/1.jpg"
            class="rounded-lg rounded-r-0"
            width="100%"
          ></v-img>
        </v-col>
        <v-col cols="6" md="6" xl="7" class="pb-0 d-flex align-end flex-column">
          <v-container class="d-flex pa-0 mb-2">
            <v-card-subtitle
              class="align-self-center text--secondary text-xs-body-2 text-xl-caption text-capitalize pa-0"
            >
              <div
                class="text-xs-body-2 text-xl-caption mt-auto mb-auto align-content-center"
              >
                {{ value.type.title }}
              </div>
            </v-card-subtitle>
            <v-btn
              plain
              class="ml-auto pa-0 justify-end"
              @click="like"
              height="20"
            >
              <v-icon
                v-if="!value.liked"
                class="text-right pa-0"
                color="#37373A"
                dense
              >
                mdi-heart-outline
              </v-icon>
              <v-icon
                v-else
                class="text-right ml-auto pa-0"
                color="#37373A"
                large
              >
                mdi-heart
              </v-icon>
            </v-btn>
          </v-container>

          <v-card-title
            class="text-subtitle-2 text-xl-subtitle-1 align-self-start font-weight-medium pa-0 mb-2 pl-0 text-break object-card__title"
            style="line-height: 1.3rem"
          >
            {{ value.title }}
          </v-card-title>
          <v-card-text class="mt-1 grow object-card__params">
            <v-row>
              <span class="mr-4">
                {{ maxGuests | word_case(['гостя', 'гостей', 'гостей']) }}
              </span>
              <span class="mr-4">
                {{ beds | word_case(['кровать', 'кровати', 'кроватей']) }}
              </span>
              <span class="mr-4">
                {{ rooms | word_case(['спальня', 'спальни', 'спальней']) }}
              </span>
              <span class="mr-4"> {{ square }} м<sup>2</sup> </span>
            </v-row>
            <v-row class="mt-3">
              <v-chip
                v-for="item in value.options"
                v-show="item.primary"
                :key="item.id"
                outlined
                small
                :value="item.id"
                class="ma-1 ml-0"
              >
                <v-icon small left>{{ item.icon }}</v-icon>
                {{ item.title }}
              </v-chip>
            </v-row>
            <v-row class="object-card__circumstances">
              <v-list dense class="pa-0">
                <v-list-item
                  v-for="item in value.circumstances"
                  :key="item.id"
                  class="pa-0 ma-0 list-item"
                >
                  <v-icon color="#00ACA2" small> mdi-circle-small </v-icon>
                  <v-list-item-content class="pa-0">
                    <v-list-item-title
                      class="font-weight-medium list-item__title"
                    >
                      {{ item.title }}</v-list-item-title
                    >
                  </v-list-item-content>
                </v-list-item>
              </v-list>
            </v-row>
          </v-card-text>
          <v-spacer></v-spacer>
          <v-card-actions
            class="object-card__card-actions object-card__card-actions_orientation_horizontal pa-0 mb-1 mt-auto d-flex"
          >
            <v-flex class="d-inline-flex align-center">
              <v-rating
                :value="value.rating.value"
                color="amber"
                dense
                half-increments
                readonly
                length="1"
                size="28"
              ></v-rating>
              <div class="text-caption">
                {{ value.rating.value }} ({{ value.reviews.count }})
              </div>
            </v-flex>
            <v-flex class="text-subtitle-2 text-right">
              <span> от {{ value.price | currency }} / ночь</span>
            </v-flex>
          </v-card-actions>
        </v-col>
      </v-row>
    </v-container>
  </v-card>

  <v-card
    v-else-if="orientation == 'vertical'"
    style="width: 350px"
    class="object-card object-card_orientation_vertical mx-auto"
    :class="{ 'object-card_is-map': map }"
  >
    <v-container>
      <v-img
        height="250"
        contain
        lazy-src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
        src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
        class="object-card__image"
        :class="{ 'object-card__image_is-map': map }"
      >
      </v-img>
      <v-card-subtitle
        class="text--secondary text-caption text-uppercase pt-1 pb-0"
        >{{ value.type.title }}</v-card-subtitle
      >
      <v-card-title
        class="text-h6 pt-0 pb-5 text-break"
        style="line-height: 1.3rem"
      >
        {{ value.title }}
      </v-card-title>
      <v-card-text>
        <v-row align="center" style="width: 90%">
          <v-rating
            :value="value.rating.value"
            color="amber"
            dense
            half-increments
            readonly
            size="14"
          ></v-rating>
          <div class="grey--text text-caption">
            {{ value.rating.value }} ({{ value.reviews.count }})
          </div>
          <div
            class="text--darken-2 text--secondary text-h6 text-right ml-auto"
          >
            <span>{{ value.price | currency }}</span>
          </div>
        </v-row>
      </v-card-text>
      <v-divider class="mx-4"></v-divider>
    </v-container>
  </v-card>
</template>

<script>
import collect from 'collect.js'

export default {
  name: 'ObjectCard',
  props: {
    orientation: {
      // horizontal || vertical
      type: String,
      default: 'horizontal',
    },
    value: {
      type: Object,
      default: () => ({
        id: '1',
        title: 'Уютная однокомнатная халупа с видом на море  с видом на море',
        price: 4500,
        type: {
          id: 1,
          name: 'flat',
          title: 'квартира',
        },
        params: [
          { id: '1', name: 'square', title: 'Площадь', value: '40' },
          { id: '2', name: 'rooms', title: 'Количество комнат', value: '2' },
          {
            id: '3',
            name: 'max_guests',
            title: 'Максимальное количество гостей',
            value: '5',
          },
          {
            id: '4',
            name: 'beds',
            title: 'Количество кроватей',
            value: '2',
          },
        ],
        options: [
          {
            id: '1',
            name: 'wifi',
            title: 'Wi-Fi',
            order: 0,
            primary: true,
            icon: 'mdi-access-point',
          },
          {
            id: '2',
            name: 'cond',
            title: 'Кондиционер',
            order: 1,
            primary: true,
            icon: 'mdi-cloud-refresh',
          },
          {
            id: '3',
            name: 'stir',
            title: 'Стиральная машина',
            order: 2,
            primary: true,
            icon: 'mdi-compass-rose',
          },
          {
            id: '4',
            name: 'utug',
            title: 'Утюг',
            order: 3,
            primary: true,
            icon: 'mdi-toilet',
          },
        ],
        circumstances: [
          { id: 1, title: 'Несколько вариантов питания' },
          { id: 2, title: 'Горящее предложение' },
          { id: 3, title: 'Предоплата' },
        ],
        rating: {
          value: 3.5,
          detail: {},
        },
        reviews: {
          count: 0,
          list: [],
        },
        liked: false,
      }),
    },
    map: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    /**
     * Collection of the value
     * @return {Collection<unknown>}
     */
    val() {
      return collect(this.value)
    },
    params() {
      return collect(this.val.get('params')).keyBy('name')
    },
    square() {
      return this.params.get('square').value
    },
    rooms() {
      return this.params.get('rooms').value
    },
    beds() {
      return this.params.get('beds').value
    },
    maxGuests() {
      return this.params.get('max_guests').value
    },
  },
  methods: {
    like() {
      console.log('like')
    },
  },
}
</script>

<style>
.object-card_is-map .v-image .v-image__image--preload {
  filter: none !important;
}
.object-card__image_is-map .v-image .v-image__image--preload {
  filter: none !important;
}
.object-card__card-actions_orientation_horizontal {
  width: 100%;
}
</style>
