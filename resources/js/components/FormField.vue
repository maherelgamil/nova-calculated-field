<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template slot="field">
      <div class="flex items-center">
        <input
          ref="theInput"
          class="w-full form-control form-input form-input-bordered"
          :id="field.attribute"
          :dusk="field.attribute"
          v-model="value"
          :disabled="isReadonly"
          v-bind="extraAttributes"
        />
      </div>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
  mixins: [HandlesValidationErrors, FormField],

  mounted() {
    if (this.shouldRegisterInitialListener) {
      this.registerChangeListener()
    }
  },

  methods: {
    changeListener(value) {
      return value => {
        this.value = value
      }
    },

    registerChangeListener() {
      Nova.$on(this.eventName, value => {
        this.calculateValue(value)
      })
    },

    calculateValue: function(value) {
      this.calculating = true;
      Nova.request()
        .post(`/maherelgamil/nova-calculated-field/calculate/${this.resourceName}/${this.field.attribute}`, {
          value: value
        }).then(response => {
          this.value = response.data.value;
          this.calculating = false;
        })
        .catch(() => {
          this.calculating = false;
        });
    },
  },

  computed: {
    shouldRegisterInitialListener() {
      return !this.field.updating
    },

    eventName() {
      return `${this.field.from}-change`
    },

    extraAttributes() {
      return this.field.extraAttributes || {}
    },
  },
}
</script>
