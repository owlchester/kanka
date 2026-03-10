
import { Extension } from '@tiptap/core'
import { PluginKey } from '@tiptap/pm/state'
import { Suggestion } from '@tiptap/suggestion'

export interface SlashCommandOptions {
    suggestion: any
}

export const SlashCommandPluginKey = new PluginKey('slashCommand')

export const SlashCommand = Extension.create<SlashCommandOptions>({
    name: 'slashCommand',

    addOptions() {
        return {
            suggestion: {
                char: '/',
                pluginKey: SlashCommandPluginKey,
                command: ({ editor, range, props }) => {
                    // Delete the slash command text
                    editor.chain().focus().deleteRange(range).run()

                    // Execute the command
                    props.command(editor)
                },
            },
        }
    },

    addProseMirrorPlugins() {
        return [
            Suggestion({
                editor: this.editor,
                ...this.options.suggestion,
            }),
        ]
    },
})
