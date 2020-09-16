<template>
  <div>
    <a role="button"
      href="#"
      v-if="editShow"
      :class="editClass"
      @click="click(data, 'edit')">
        <span>
            <i v-if="editIconShow" :class="editIcon" aria-hidden="true"></i>
        </span>
      &nbsp;
      {{ editText }}
    </a>
    <a role="button"
      href="#"
      v-if="previewShow"
      :class="previewClass"
      @click="click(data, 'preview')">
        <span>
            <i v-if="previewIconShow" :class="previewIcon" aria-hidden="true"></i>
        </span>
      &nbsp;
      {{ previewText }}
    </a>
    <a role="button"
      href="#"
      v-if="deleteShow"
      :class="deleteClass"
      @click="click(data, 'delete')">
        <span>
            <i v-if="deleteIconShow" :class="deleteIcon" aria-hidden="true"></i>
        </span>
      &nbsp;
      {{ deleteText }}
    </a>
  </div>
</template>

<script>
  export default {
    name: "ButtonGroup",
    props: {
      data: {},
      name: {},
      click: {
        type: Function,
        default: () => {}
      },
      editShow: {
        type: Boolean,
        default: true,
        required: false
      },
      deleteShow: {
        type: Boolean,
        default: true,
        required: false
      },
      previewShow: {
        type: Boolean,
        default: true,
        required: false
      },
      editIconShow: {
        type: Boolean,
        default: true,
        required: false
      },
      deleteIconShow: {
        type: Boolean,
        default: true,
        required: false
      },
      previewIconShow: {
        type: Boolean,
        default: true,
        required: false
      },
      editIcon: {
        type: String,
        default: () => ('feather icon-edit')
      },
      deleteIcon: {
        type: String,
        default: 'feather icon-trash'
      },
      previewIcon: {
        type: String,
        default: 'feather icon-eye'
      },
      editText: {
        type: String,
        default: ''
      },
      deleteText: {
        type: String,
        default: ''
      },
      previewText: {
        type: String,
        default: ''
      },
      editClass: {
        type: String,
        default: 'text-primary'
      },
      deleteClass: {
        type: String,
        default: 'text-danger'
      },
      previewClass: {
        type: String,
        default: 'text-info'
      },
    }
  }
</script>

<style>

</style>
