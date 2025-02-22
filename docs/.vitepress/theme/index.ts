// https://vitepress.dev/guide/custom-theme
import { h, toRefs } from 'vue'
import { useData, useRoute, type Theme } from 'vitepress'
import DefaultTheme from 'vitepress/theme'
import { enhanceAppWithTabs } from 'vitepress-plugin-tabs/client'
import giscusTalk from 'vitepress-plugin-comment-with-giscus';
import googleAnalytics from 'vitepress-plugin-google-analytics'
import './style.css'

export default {
  extends: DefaultTheme,
  Layout: () => {
    return h(DefaultTheme.Layout, null, {
      // https://vitepress.dev/guide/extending-default-theme#layout-slots
    })
  },
  enhanceApp({ app }) {
    enhanceAppWithTabs(app);
    googleAnalytics({
      id: 'G-H87WSJSM7G', // Replace with your GoogleAnalytics ID, which should start with the 'G-'
    });
  },
  setup() {
    const { frontmatter } = toRefs(useData());
    const route = useRoute();

    giscusTalk({
      repo: 'damoang-users/rx-da_reaction',
      repoId: 'R_kgDOODUtRg',
      category: 'General',
      categoryId: 'DIC_kwDOODUtRs4Cn0sh',
      mapping: 'pathname',
      inputPosition: 'top',
      lang: 'ko',
      theme: 'transparent_dark',
    }, {
      frontmatter, route
    },
      // Whether to activate the comment area on all pages.
      // The default is true, which means enabled, this parameter can be ignored;
      // If it is false, it means it is not enabled.
      // You can use `comment: true` preface to enable it separately on the page.
      true
    );
  }
} satisfies Theme
