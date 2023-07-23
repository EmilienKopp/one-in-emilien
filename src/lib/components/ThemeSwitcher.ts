import invariant from "tiny-invariant";

export function init() {

const themes = ["light", "dark"];
  const button = document.querySelector("#theme-switcher");
  invariant(button, "button should not be null");

  const getThemeCurrent = () => document.documentElement.dataset.theme;
  const getThemeNext = () => {
    const themeCurrent = getThemeCurrent();
    invariant(themeCurrent, "themeCurrent should not be undefined");
    const indexThemeCurrent = themes.indexOf(themeCurrent);
    return themes[(indexThemeCurrent + 1) % themes.length];
  };

  const updateIcon = () => {
    const themeCurrent = getThemeCurrent();
    document
      .querySelector(`#icon-theme-${themeCurrent}`)
      ?.classList.add("hidden");
    const themeNext = getThemeNext();
    document
      .querySelector(`#icon-theme-${themeNext}`)
      ?.classList.remove("hidden");
  };

  button?.addEventListener("click", () => {
    const themeNext = getThemeNext();
    document.documentElement.dataset.theme = themeNext;
    localStorage.setItem("theme", themeNext);
    updateIcon();
  });

  updateIcon();
}