<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from "../../Layouts/AppLayout.vue";
import Card from "../../Components/Card.vue";
import Header from "../../Components/Header.vue";
import UserDetails from "../../Pages/Users/Partials/Details.vue"
import Pagination from "../../Components/Pagination.vue";
import Editor from "primevue/editor";
import { Button, Message } from "primevue";

const props = defineProps ( { discussion: Object, posts: Object } )
const discussion = props.discussion

const submit = () => {
  form.post ( route ( 'discussions.reply', { discussion: discussion.id } ), { preserveScroll: true } );
}

const form = useForm ( {
  content: '',
  on_type: discussion.on_type,
  on_id: discussion.on_id,
} );


</script>

<template>
  <AppLayout>
    <Head title="Show" />
    <Header
        header="Discussion"
        label="Back"
    />
    <Card>
      <div class="flex justify-between gap-4">
        <div>
          <h1 class="card-header">{{ discussion.title }}</h1>
          <p class="text-sm">
            Created {{ discussion.created_at }} <br />by {{ discussion.created_by.full_name }}
          </p>
        </div>
        <div class="text-sm text-right">
          <h2 class="font-bold mb-2">Users In This Discussion</h2>
          <span
              class="float-left"
              v-for="user in discussion.users"
              :key="user.id"
          >
            <UserDetails :user="user" :show_name="false" />
          </span>
        </div>
      </div>
    </Card>
    <div v-for="post in posts.data">
      <div class="flex my-2 py-4 justify-between border-b border-b-darker-300 ">
        <div
            v-html="post.content"
            class="text-pretty wrap-break-word max-w-3/4"
        />
        <div class="text-sm text-right shrink-0">
          <UserDetails :user="post.created_by" />
          {{ post.created_at }}
        </div>
      </div>
    </div>
    <form @submit.prevent="submit">
      <label
          for="content"
          class="font-semibold"
      >Reply</label>
      <Editor
          id="content"
          v-model="form.content"
          :invalid="!!form.errors.content"
          placeholder="Enter content (optional)"
          editorStyle="height: 200px"
          class="w-full"
      />
      <Message
          v-if="form.errors.content"
          severity="error"
          :closable="false"
      >
        {{ form.errors.content }}
      </Message>
      <div class="flex justify-center p-4">
        <Button
            type="submit"
            label="Reply"
            icon="pi pi-check"
            severity="primary"
        />
      </div>
    </form>
    <Pagination :pagination="posts" />
  </AppLayout>
</template>
