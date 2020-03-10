<template>
    <main class="inbox">
    <div class="box-header with-border">
        <h3 class="box-title">Compose New Message</h3>
    </div>
    <!-- /.box-header -->
    <form @submit.prevent="sendEmail" @keydown="form.onKeydown($event)">
        <div class="box-body">
            <div class="form-group">
                <input name="to" v-model="form.to" class="form-control" placeholder="To:">
            </div>
            <div class="form-group">
                <input name="subject" v-model="form.subject" class="form-control" placeholder="Subject:">
            </div>
            <div class="form-group">
                <wysiwyg v-model="form.html" />
            </div>
            <div class="form-group">
                <div class="btn btn-default btn-file">
                    <i class="fa fa-paperclip"></i> Attachment
                    <input type="file" name="attachment">
                </div>
                <p class="help-block">Max. 32MB</p>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-default">
            <i class="fas fa-pencil-alt"></i> Draft
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-envelope"></i> Send
          </button>
        </div>
        <button type="reset" class="btn btn-default">
          <i class="fas fa-times"></i> Discard
        </button>
      </div>
        <!-- /.box-footer -->
    </form>
</main>
</template>

<script>
export default {
  data() {
    return {
      id: 0,
      // Create a new form instance
      form: new Form({
        id: "",
        from: "",
        subject: "",
        html: "",
        attachments: ""
      }),
      // { [module]: boolean (set true to hide) }
      hideModules: { bold: true },

      // if the image option is not set, images are inserted as base64
      image: {
        uploadURL: "/api/myEndpoint",
        dropzoneOptions: {}
      },
    };
  },

  methods: {
    sendEmail() {
      // Submit the form via a POST request
      this.form.post(Inbox.basePath + "/api/send").then(({ data }) => {
        console.log(data);
      });
    }
  },
  mounted() {
  }
};
</script>
