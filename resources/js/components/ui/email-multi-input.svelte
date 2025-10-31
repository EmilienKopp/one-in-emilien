<script lang="ts">
  import { SvelteSet } from "svelte/reactivity";
  import * as Table from "$components/ui/table";
  import Swap from "$components/ui/swap/swap.svelte";
  import { Table as TableIcon, Tag as TagIcon } from "lucide-svelte";
  import { slide } from "svelte/transition";
  import Button from "./button/button.svelte";

  interface EmailTagInputProps {
    emails?: SvelteSet<string>;
    placeholder?: string;
    disabled?: boolean;
    maxEmails?: number;
    allowDuplicates?: boolean;
    onEmailsChange?: (emails: SvelteSet<string>) => void;
    class?: string;
    canToggleDisplayMode?: boolean;
  }

  let {
    emails = $bindable(new SvelteSet<string>()),
    placeholder = "Enter email addresses",
    disabled = false,
    maxEmails,
    allowDuplicates = false,
    onEmailsChange,
    class: className = "",
    canToggleDisplayMode = true,
  }: EmailTagInputProps = $props();

  let inputValue = $state("");
  let inputElement = $state<HTMLInputElement>();
  let containerElement = $state<HTMLDivElement>();
  let focusedTagIndex = $state<number | null>(null);
  let view: "tags" | "table" = $state("tags");

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function isValidEmail(email: string): boolean {
    return emailRegex.test(email.trim());
  }

  function addEmail(email: string): void {
    const trimmedEmail = email.trim().toLowerCase();

    if (!trimmedEmail) return;
    if (!isValidEmail(trimmedEmail)) return;
    if (!allowDuplicates && emails.has(trimmedEmail)) return;
    if (maxEmails && emails.size >= maxEmails) return;

    emails.add(trimmedEmail);
    onEmailsChange?.(emails);
  }

  function removeEmail(email: string): void {
    emails.delete(email);
    onEmailsChange?.(emails);
    focusedTagIndex = null;
  }

  function processInput(value: string): void {
    const potentialEmails = value.split(/[^a-zA-Z0-9@._+-]+/).filter(Boolean);

    potentialEmails.forEach((email) => {
      addEmail(email);
    });

    inputValue = "";
  }

  function handleKeydown(event: KeyboardEvent): void {
    if (disabled) return;

    switch (event.key) {
      case "Enter":
      case "Tab":
      case ",":
      case ";":
        event.preventDefault();
        if (inputValue.trim()) {
          processInput(inputValue);
        }
        break;

      case "Backspace":
        if (!inputValue && emails.size > 0) {
          if (focusedTagIndex !== null) {
            removeEmail(focusedTagIndex);
          } else {
            focusedTagIndex = emails.size - 1;
          }
        } else if (focusedTagIndex !== null) {
          event.preventDefault();
          removeEmail(focusedTagIndex);
        }
        break;

      case "ArrowLeft":
        if (!inputValue && emails.size > 0) {
          event.preventDefault();
          if (focusedTagIndex === null) {
            focusedTagIndex = emails.size - 1;
          } else if (focusedTagIndex > 0) {
            focusedTagIndex--;
          }
        }
        break;

      case "ArrowRight":
        if (focusedTagIndex !== null) {
          event.preventDefault();
          if (focusedTagIndex < emails.size - 1) {
            focusedTagIndex++;
          } else {
            focusedTagIndex = null;
            inputElement?.focus();
          }
        }
        break;

      case "Escape":
        focusedTagIndex = null;
        break;
    }
  }

  function handlePaste(event: ClipboardEvent): void {
    if (disabled) return;

    event.preventDefault();
    const pastedText = event.clipboardData?.getData("text") || "";

    const combinedText = inputValue + pastedText;
    processInput(combinedText);
  }

  function handleInput(event: Event): void {
    const target = event.target as HTMLInputElement;
    inputValue = target.value;

    const separatorRegex = /[^a-zA-Z0-9@._+-]/;
    if (separatorRegex.test(inputValue)) {
      processInput(inputValue);
    }
  }

  function handleContainerClick(): void {
    if (!disabled) {
      focusedTagIndex = null;
      inputElement?.focus();
    }
  }

  function handleTagClick(index: number, event: MouseEvent): void {
    event.stopPropagation();
    focusedTagIndex = focusedTagIndex === index ? null : index;
  }

  function handleTagRemove(text: string, event: MouseEvent): void {
    event.stopPropagation();
    removeEmail(text);
  }

  // outclick handling
  function handleDocumentClick(event: MouseEvent): void {
    if (!containerElement?.contains(event.target as Node)) {
      focusedTagIndex = null;
    }
  }

  $effect(() => {
    document.addEventListener("click", handleDocumentClick);
    return () => document.removeEventListener("click", handleDocumentClick);
  });
</script>

<div class="flex flex-col items-end justify-center gap-3 w-full">
  {#if canToggleDisplayMode && emails.size > 0}
    <Swap values={{ on: "tags", off: "table" }} bind:selected={view}>
      {#snippet on()}
        <TagIcon />
      {/snippet}
      {#snippet off()}
        <TableIcon />
      {/snippet}
    </Swap>
  {/if}

  {#if view === "tags"}
    <div
      bind:this={containerElement}
      class="min-h-[42px] min-w-full border-2 border-slate-200 rounded-lg border-input bg-background selection:bg-primary dark:bg-input/30 selection:text-primary-foreground ring-offset-background placeholder:text-muted-foreground shadow-xs outline-none transition-[color,box-shadow] p-1 cursor-text transition-colors duration-200 focus-within:border-blue-500 focus-within:outline-0 focus-within:shadow-[0_0_0_3px_rgba(59,130,246,0.1)] disabled:bg-slate-50 disabled:border-slate-200 disabled:cursor-not-allowed disabled:opacity-60 {className}"
      class:disabled
      class:max-h-72={view === "table"}
      onclick={handleContainerClick}
      role="textbox"
      tabindex="-1">
      <div class="flex flex-wrap gap-1 items-center min-h-[34px]">
        {#each emails as email, index (email)}
          <div
            class="inline-flex items-center bg-slate-100 border border-slate-300 rounded-md px-1.5 py-1 text-sm text-slate-700 cursor-pointer transition-all duration-200 max-w-[200px] hover:bg-slate-200 hover:border-slate-400 sm:max-w-[150px] sm:text-[13px]"
            class:!bg-blue-50={focusedTagIndex === index}
            class:!border-blue-500={focusedTagIndex === index}
            class:!shadow-[0_0_0_2px_rgba(59,130,246,0.2)]={focusedTagIndex ===
              index}
            onclick={(e) => handleTagClick(index, e)}
            role="button"
            tabindex="0">
            <span
              class="overflow-hidden text-ellipsis whitespace-nowrap flex-1 min-w-0">
              {email}
            </span>
            <button
              type="button"
              class="ml-1 bg-transparent border-0 text-slate-500 cursor-pointer text-base font-bold p-0 w-4 h-4 flex items-center justify-center rounded-sm transition-all duration-200 flex-shrink-0 hover:bg-red-500 hover:text-white"
              onclick={(e) => handleTagRemove(email, e)}
              aria-label="Remove {email}"
              tabindex="-1">
              ×
            </button>
          </div>
        {/each}

        <input
          bind:this={inputElement}
          bind:value={inputValue}
          type="text"
          {placeholder}
          {disabled}
          class="border-0 outline-0 bg-transparent flex-1 min-w-[120px] text-sm p-1.5 text-foreground placeholder:text-slate-400 disabled:cursor-not-allowed sm:min-w-[100px] sm:text-[13px]"
          onkeydown={handleKeydown}
          onpaste={handlePaste}
          oninput={handleInput}
          autocomplete="off"
          spellcheck="false" />
      </div>

      {#if maxEmails && emails.length >= maxEmails}
        <div class="mt-1 text-xs text-amber-500 px-1.5 py-0.5">
          Maximum of {maxEmails} emails reached
        </div>
      {/if}
    </div>
  {/if}
</div>

{#if view === "table"}
  <div class="mt-5 px-2" transition:slide>
    <Table.Root>
      <Table.Header>
        <Table.Row>
          <Table.Cell>Email</Table.Cell>
          <Table.Cell>Actions</Table.Cell>
        </Table.Row>
      </Table.Header>
      <Table.Body>
        {#each emails as email}
          <Table.Row key={email}>
            <Table.Cell>{email}</Table.Cell>
            <Table.Cell>
              <button onClick={() => removeEmail(email)}>Remove</button>
            </Table.Cell>
          </Table.Row>
        {/each}
      </Table.Body>
    </Table.Root>
  </div>
{/if}
