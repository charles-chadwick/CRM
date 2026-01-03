<!--suppress JSUnresolvedReference -->
<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import UserDetails from "@/Pages/Users/Partials/Details.vue"
import Pagination from "@/Components/Pagination.vue";
import DeleteButton from "@/Components/ActionButtons.vue";

import Editor from "primevue/editor";
import { Button, ConfirmDialog, InputText, Message } from "primevue";

const props = defineProps ( { discussion: Object, posts: Object, on_type: String, on_id: Number } )
const discussion = props.discussion

const submit = () => {
  if ( discussion.id ) {
    form.post ( route ( 'discussions.reply', { discussion: discussion.id } ), { preserveScroll: true } );
  } else {
    form.post ( route ( 'discussions.store' ) );
  }
}

const form = useForm ( {
  title: discussion.title || '',
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
    <ConfirmDialog />
    <Card>
      <div class="flex justify-between gap-4">


        <!-- discussion title and header -->
        <div v-if="!discussion.id">
          <label
              for="title"
              class="font-semibold"
          >Thread Title</label>
          <InputText
              id="title"
              v-model="form.title"
              :invalid="!!form.errors.title"
              placeholder="Enter thread title"
              class="w-full"
          />
          <Message
              v-if="form.errors.title"
              severity="error"
              :closable="false"
          >
            {{ form.errors.title }}
          </Message>
        </div>
        <div v-else>
          <h1 class="card-header">{{ discussion.title }}</h1>
          <p class="text-sm">
            Created {{ discussion.created_at }} <br />by {{ discussion.created_by.full_name }}
          </p>
        </div>
        <!-- end discussion title and header -->


        <!-- start users -->
        <div
            class="text-sm text-right"
            v-if="discussion.users?.length"
        >
          <h2 class="font-bold mb-2">Users In This Discussion</h2>
          <span
              class="float-left"
              v-for="user in discussion.users"
              :key="user.id"
          >
            <UserDetails
                :user="user"
                :show_name="false"
            />
          </span>
        </div>
        <!-- end users -->

      </div>
    </Card>
    <div
        v-if="posts?.data?.length > 0"
        v-for="post in posts.data"
    >
      <div class="flex my-2 py-4 px-2 justify-between border-b border-b-darker-300 ">
        <div
            v-html="post.content"
            class="text-pretty wrap-break-word max-w-3/4"
        />
        <div class="text-sm text-right shrink-0">
          <UserDetails :user="post.created_by" />
          <p class="mb-2">{{ post.created_at }}</p>
          <DeleteButton
              prefix="discussions.posts"
              :id="post.id"
              message="Post"
          />
        </div>
      </div>

    </div>
    <Pagination
        v-if="posts?.data?.length > 10"
        :pagination="posts"
    />

    <form
        @submit.prevent="submit"
        class="mt-4"
    >
      <label
          v-if="discussion.id"
          for="content"
          class="font-semibold px-2"
      >Reply</label>
      <label
          v-else
          for="content"
          class="font-semibold py-6 px-2"
      >First Post</label>
      <Editor
          id="content"
          v-model="form.content"
          :invalid="!!form.errors.content"
          placeholder="Enter content (optional)"
          editorStyle="height: 200px"
          class="w-full mt-4"
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
            :label="discussion.id ? 'Reply' : 'Create Thread'"
            icon="pi pi-check"
            severity="primary"
        />
      </div>
    </form>
  </AppLayout>
</template>
