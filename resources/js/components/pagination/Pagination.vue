<template>
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
        <a class="page-link" href="#" @click.prevent="switched(meta.current_page - 1)">Previous</a>
      </li>
      <template v-if="section > 1">
        <li class="page-item">
          <a class="page-link" href="#" @click.prevent="switched(1)">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" @click.prevent="goBackASection">...</a>
        </li>
      </template>
      <li
        class="page-item"
        v-for="page in pages"
        :key="page"
        :class="{ active: meta.current_page === page }"
      >
        <a class="page-link" href="#" @click.prevent="switched(page)">{{ page }}</a>
      </li>
      <template v-if="section < sections">
        <li class="page-item">
          <a class="page-link" href="#" @click.prevent="goForwardASection">...</a>
        </li>
        <li class="page-item">
          <a
            class="page-link"
            href="#"
            @click.prevent="switched(meta.last_page)"
          >{{ meta.last_page }}</a>
        </li>
      </template>
      <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
        <a class="page-link" href="#" @click.prevent="switched(meta.current_page + 1)">Next</a>
      </li>
    </ul>
  </nav>
</template>
<script>
export default {
  props: ["meta"],
  data() {
    return {
      numbersPersection: 7
    };
  },
  computed: {
    section() {
      return Math.ceil(this.meta.current_page / this.numbersPersection);
    },
    sections() {
      return Math.ceil(this.meta.last_page / this.numbersPersection);
    },
    lastPage() {
      let lastPage =
        (this.section - 1) * this.numbersPersection + this.numbersPersection;
      if (this.section === this.sections) {
        lastPage = this.meta.last_page;
      }
      return lastPage;
    },
    pages() {
      return _.range(
        (this.section - 1) * this.numbersPersection + 1,
        this.lastPage + 1
      );
    }
  },
  mounted() {
    if (this.meta.current_page > this.meta.last_page) {
      this.switched(this.meta.last_page);
    }
  },
  methods: {
    switched(page) {
      if (this.pageIsOutOfBounds(page)) {
        return;
      }

      this.$emit("pagination:switched", page);
    },
    pageIsOutOfBounds(page) {
      return page <= 0 || page > this.meta.last_page;
    },
    goBackASection() {
      this.switched(this.firsPageOfSection(this.section - 1));
    },
    goForwardASection() {
      this.switched(this.firsPageOfSection(this.section + 1));
    },
    firsPageOfSection(section) {
      return (section - 1) * this.numbersPersection + 1;
    }
  }
};
</script>
