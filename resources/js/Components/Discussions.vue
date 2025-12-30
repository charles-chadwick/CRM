<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Button, Dialog, Card } from 'primevue';
import Editor from 'primevue/editor';

const props = defineProps ( {
  discussions: Array,
  on_id: Number,
  on_type: String
} );

const showNewThreadModal = ref ( false );
const showPostsModal = ref ( false );
const selectedDiscussion = ref ( null );
const replyingTo = ref ( null );

const threadForm = useForm ( {
  on_id: props.on_id,
  on_type: props.on_type,
  title: '',
  content: ''
} );

const replyForm = useForm ( {
  content: ''
} );

const submitThread = () => {
  threadForm.post ( route ( 'discussions.store' ), {
    onSuccess: () => {
      showNewThreadModal.value = false;
      threadForm.reset ();
    }
  } );
};

const submitReply = ( discussionId ) => {
  replyForm.post ( route ( 'discussions.reply', discussionId ), {
    onSuccess: ( response ) => {
      if ( selectedDiscussion.value && response.props.post ) {
        selectedDiscussion.value.posts.push ( response.props.post );
      }
      replyingTo.value = null;
      replyForm.reset ();
    }
  } );
};

const deletePost = ( postId ) => {
  if ( confirm ( 'Are you sure you want to delete this post?' ) ) {
    useForm ( {} ).delete ( route ( 'discussions.posts.destroy', postId ) );
  }
};

const openDiscussion = ( discussion ) => {
  selectedDiscussion.value = discussion;
  showPostsModal.value = true;
  replyingTo.value = null;
};
</script>

<template>
  <div class="space-y-4">
    <div class="flex justify-between items-center">
      <h3 class="text-lg font-bold">Discussions</h3>
      <a
          href="#"
          @click.prevent="showNewThreadModal = true"
      >Add New</a>
    </div>

    <div
        v-if="discussions.length === 0"
        class="text-center"
    >No discussions yet.
    </div>

    <div
        v-for="discussion in discussions"
        :key="discussion.id"
        class=""
    >
      <h4
          class="pb-2 mb-3 cursor-pointer"
          @click="openDiscussion(discussion)"
      >{{ discussion.title }}
      </h4>
    </div>

    <Dialog
        v-model:visible="showNewThreadModal"
        header="Start New Thread"
        :style="{ width: '50vw' }"
        modal
    >
      <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
          <label
              for="title"
              class="font-bold"
          >Title</label>
          <input
              id="title"
              v-model="threadForm.title"
              class="p-2 border rounded"
              placeholder="Discussion title..."
          />
        </div>
        <div class="flex flex-col gap-2">
          <label class="font-bold">Message</label>
          <Editor
              v-model="threadForm.content"
              editorStyle="height: 200px"
          />
        </div>
      </div>
      <template #footer>
        <Button
            label="Cancel"
            severity="secondary"
            @click="showNewThreadModal = false"
        />
        <Button
            label="Create Thread"
            @click="submitThread"
            :loading="threadForm.processing"
        />
      </template>
    </Dialog>

    <Dialog
        v-model:visible="showPostsModal"
        :header="selectedDiscussion?.title"
        :style="{ width: '50vw' }"
        modal
    >
      <div
          v-if="selectedDiscussion"
          class="space-y-4"
      >
        <div class="space-y-4">
          <div
              v-for="post in selectedDiscussion.posts"
              :key="post.id"
              class="flex flex-col gap-1"
          >
            <div class="flex justify-between">
              <span>{{ post.created_by?.first_name }} {{ post.created_by?.last_name }} - {{ post.created_at }}</span>
              <Button
                  icon="pi pi-trash"
                  severity="danger"
                  text
                  size="small"
                  @click="deletePost(post.id)"
              />
            </div>
            <div
                class="prose prose-sm max-w-none"
                v-html="post.content"
            ></div>
          </div>
        </div>

        <div class="mt-4 pt-2 border-t">
          <Button
              v-if="replyingTo !== selectedDiscussion.id"
              label="Reply"
              icon="pi pi-reply"
              text
              size="small"
              @click="replyingTo = selectedDiscussion.id"
          />

          <div
              v-if="replyingTo === selectedDiscussion.id"
              class="mt-2"
          >
            <Editor
                v-model="replyForm.content"
                editorStyle="height: 150px"
                class="mb-2"
            />
            <div class="flex gap-2">
              <Button
                  label="Send"
                  size="small"
                  @click="submitReply(selectedDiscussion.id)"
                  :loading="replyForm.processing"
              />
              <Button
                  label="Cancel"
                  severity="secondary"
                  size="small"
                  @click="replyingTo = null"
              />
            </div>
          </div>
        </div>
      </div>
    </Dialog>
  </div>
</template>