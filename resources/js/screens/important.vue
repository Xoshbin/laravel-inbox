<template>
  <main class="inbox">
    <div class="toolbar">
      <div class="btn-group">
        <a
          href="#"
          @click.prevent="bulkUnread"
          type="button"
          class="btn btn-light"
        >
          <span class="fa fa-envelope"></span>
        </a>
        <a
          href="#"
          @click.prevent="bulkStar"
          type="button"
          class="btn btn-light"
          ><span class="action"><i class="fas fa-star"></i></span
        ></a>
        <a
          type="button"
          href="#"
          @click.prevent="bulkBookmark"
          class="btn btn-light"
        >
          <span class="far fa-bookmark"></span>
        </a>
      </div>
      <a
        href="#"
        @click.prevent="bulkDelete"
        type="button"
        class="btn btn-light delete_all"
      >
        <span class="fas fa-trash"></span>
      </a>
      <div class="btn-group float-right">
        <pagination :data="emails" @pagination-change-page="loadEmails"></pagination>
      </div>
    </div>

    <ul class="messages">
      <li v-for="email in emails.data" :key="email.id" class="message" v-bind:class="{ unread: !email.read }">
        <div class="actions">
          <input
            type="checkbox"
            class="action sub_chk"
            :id="email.id"
            :value="email.id"
            v-model="checkedEmails"
          />
          <a href="#" @click.prevent="starEmail(email.id)">
              <span class="action" key="fas" v-if="email.starred"><i class="fas fa-star"></i></span>
              <span class="action" key="far" v-else><i class="far fa-star"></i></span>
            </a>
        </div>
        <router-link :to="{ name: 'show', params: { id: email.id } }">
          <div class="header">
            <span class="from">{{ email.from }}</span>
            <span class="date">
              <span class="fas fa-paperclip"></span> {{ email.date }}</span
            >
          </div>
          <div class="title">
            {{ email.subject }}
          </div>
          <div class="description">
            {{ email.html | striphtml }}
          </div>
        </router-link>
      </li>
    </ul>
  </main>
</template>

<script>
export default {
  data() {
    return {
      checkedEmails: [],
      emails: {}
    };
  },
  methods: {
    loadEmails(page = 1) {
			axios.get(Inbox.basePath + "/api/important?page=" + page)
				.then(({ data }) => (this.emails = data));
    },
    starEmail(id) {
      axios.get(Inbox.basePath + "/api/star/" + id).then(() => {
        this.loadEmails();
      });
    },
    bulkStar() {
      axios
        .post(Inbox.basePath + "/api/bulkstar", { ids: this.checkedEmails })
        .then(this.loadEmails());
    },
    bulkBookmark() {
      axios
        .post(Inbox.basePath + "/api/bulkbookmark", { ids: this.checkedEmails })
        .then(this.loadEmails());
    },
    bulkDelete() {
      axios
        .post(Inbox.basePath + "/api/bulkdelete", { ids: this.checkedEmails })
        .then(this.loadEmails());
    },
    bulkUnread() {
      axios
        .post(Inbox.basePath + "/api/bulkunread", { ids: this.checkedEmails })
        .then(this.loadEmails());
    }
  },
  filters: {
    striphtml(value) {
      var div = document.createElement("div");
      div.innerHTML = value;
      var text = div.textContent || div.innerText || "";
      return text;
    }
  },
  mounted() {
    this.loadEmails();
  }
};
</script>
