import { expect, test } from "@playwright/test";
import { PaydayFormTestIds } from "../frontend/components/PaydayForm";
import { PaydayResultTestIds } from "../frontend/components/PaydayResult";

test.describe("PaydayCalculator page", () => {
  test("has title", async ({ page }) => {
    await page.goto("/");
    await expect(page).toHaveTitle("True9 PayDay system");
  });

  test("has form items", async ({ page }) => {
    await page.goto("/");
    await expect(page.getByTestId(PaydayFormTestIds.month)).toBeVisible();
    await expect(page.getByTestId(PaydayFormTestIds.year)).toBeVisible();
    await expect(
      page.getByTestId(PaydayFormTestIds.submitButton),
    ).toBeVisible();
  });

  test("can submit", async ({ page }) => {
    await page.goto("/");
    await page.getByTestId(PaydayFormTestIds.month).selectOption("10");
    await page.getByTestId(PaydayFormTestIds.year).fill("2026");
    await page.getByTestId(PaydayFormTestIds.submitButton).click();

    await expect(page.getByTestId(PaydayResultTestIds.payDate)).toHaveText(
      "Friday, 30/10/2026",
    );
    await expect(page.getByTestId(PaydayResultTestIds.paymentDate)).toHaveText(
      "Monday, 26/10/2026",
    );
  });
});
