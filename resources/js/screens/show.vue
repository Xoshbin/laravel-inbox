<template>
  <main class="inbox">
    <div v-for="showEmail in email" :key="showEmail.id">
      <div class="toolbar">
        <div class="btn-group">
          <a href="#" @click.prevent="unreadEmail(showEmail.id)" type="button" class="btn btn-light">
              <span class="action" key="fa-envelope" v-if="showEmail.read"><i class="fas fa-envelope"></i></span>
              <span class="action" key="fa-envelope-open" v-else><i class="fas fa-envelope-open"></i></span>
          </a>
          <a href="#" @click.prevent="starEmail(showEmail.id)" type="button" class="btn btn-light">
              <span class="action" key="fas" v-if="showEmail.starred"><i class="fas fa-star"></i></span>
              <span class="action" key="far" v-else><i class="far fa-star"></i></span>
          </a>
          <a href="#" @click.prevent="bookmarkEmail(showEmail.id)" type="button" class="btn btn-light">
            <span class="action" key="fas" v-if="showEmail.starred"><i class="fas fa-bookmark"></i></span>
            <span class="action" key="far" v-else><i class="far fa-bookmark"></i></span>
          </a>
        </div>
        <div class="btn-group">
          <router-link
            :to="{ name: 'reply', params: { id: showEmail.id } }"
            type="button"
            class="btn btn-light"
            ><i class="fa fa-reply"></i></router-link
          >
          <router-link
            :to="{ name: 'forward', params: { id: showEmail.id } }"
            type="button"
            class="btn btn-light"
            ><i class="fa fa-share"></i></router-link
          >
        </div>
        <a
          type="button"
          href="#"
          @click.prevent="deleteEmail(showEmail.id)"
          class="btn btn-light"
        >
          <span class="fas fa-trash"></span>
        </a>
        <div class="btn-group">
          <a
            type="button"
            class="btn btn-light dropdown-toggle"
            data-toggle="dropdown"
          >
            <span class="fas fa-tags"></span>
            <span class="caret"></span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#"
              >add label <span class="badge badge-danger"> Home</span></a
            >
            <a class="dropdown-item" href="#"
              >add label <span class="badge badge-info"> Job</span></a
            >
            <a class="dropdown-item" href="#"
              >add label <span class="badge badge-success"> Clients</span></a
            >
            <a class="dropdown-item" href="#"
              >add label <span class="badge badge-warning"> News</span></a
            >
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="mailbox-read-info">
          <h3>{{ showEmail.subject }}</h3>
          <h5>
            From: {{ showEmail.from }}
            <span class="mailbox-read-time pull-right">{{
              showEmail.date
            }}</span>
          </h5>
        </div>
        <!-- /.mailbox-read-info -->
        <div class="body-box">
            <div class="mailbox-read-message" v-html="showEmail.html"></div>
        </div>
        <!-- /.mailbox-read-message -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <ul class="mailbox-attachments clearfix">
          <li v-for="attachment in showEmail.attachments" :key="attachment.id">
            <span class="mailbox-attachment-icon"
              ><i class="fas fa-file-pdf"></i
            ></span>

            <div class="mailbox-attachment-info">
              <a href="#" class="mailbox-attachment-name"
                ><i class="fa fa-paperclip"></i> {{ attachment.getFilename }}</a
              >
              <span class="mailbox-attachment-size">
                1,245 KB
                <!-- <a href="{{ attachment.getFilename }}"
                                    class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a> -->
              </span>
            </div>
          </li>
        </ul>
      </div>
      <!-- /.box-footer -->
      <div class="box-footer">
        <div class="pull-right">
          <router-link
            :to="{ name: 'reply', params: { id: showEmail.id } }"
            type="button"
            class="btn btn-default"
            ><i class="fa fa-reply"></i> Reply</router-link
          >
          <router-link
            :to="{ name: 'forward', params: { id: showEmail.id } }"
            type="button"
            class="btn btn-default"
            ><i class="fa fa-share"></i> Forward</router-link
          >
        </div>
        <a
          type="button"
          href="#"
          @click.prevent="deleteEmail(showEmail.id)"
          class="btn btn-default"
          ><i class="fas fa-trash"></i> Delete</a
        >
        <button type="button" class="btn btn-default">
          <i class="fa fa-print"></i> Print
        </button>
      </div>
      <!-- /.box-footer -->
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      email: {},
      id: 0
    };
  },
  methods: {
    loadEmail(id) {
      axios
        .get(Inbox.basePath + "/api/show/" + this.id)
        .then(({ data }) => (this.email = data.data));
    },
    starEmail(id) {
      axios.get(Inbox.basePath + "/api/star/" + this.id).then(() => {
        this.loadEmail(this.id);
      });
    },
    bookmarkEmail(id) {
      axios.get(Inbox.basePath + "/api/bookmark/" + this.id).then(() => {
        this.loadEmail(this.id);
      });
    },
    unreadEmail(id) {
      axios.get(Inbox.basePath + "/api/unread/" + this.id).then(() => {
        this.loadEmail(this.id);
      });
    },
    deleteEmail(id) {
      axios.get(Inbox.basePath + "/api/delete/" + this.id).then(() => {
        this.$router.push('/dashboard');
      });
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
    this.id = this.$route.params.id;
    this.loadEmail(this.$route.params.id);
  }
};
</script>

<style scoped>

.body-box {
    padding: 1.5rem;
    margin-right: 0;
    margin-left: 0;
    border-width: .2rem;
    position: relative;
    padding: 1rem;
    margin: 1rem -15px 0;
    border: solid #f8f9fa;
}
</style>