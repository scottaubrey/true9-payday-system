import { afterAll, beforeEach, describe, expect, it, spyOn } from "bun:test";
import { render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { PaydayFormTestIds } from "../components/PaydayForm";
import { PaydayResultTestIds } from "../components/PaydayResult";
import { PaydayCalculator } from "./PaydayCalculator";

const spyFetch = spyOn(globalThis, "fetch");

describe("PaydayCalculator", () => {
  beforeEach(() => {
    spyFetch.mockReset();
  });

  afterAll(() => {
    spyFetch.mockRestore();
  });
  it("shows a pay day form", () => {
    render(<PaydayCalculator />);

    const paydayCalculatorForm = screen.getByTestId(PaydayFormTestIds.form);
    expect(paydayCalculatorForm).toBeVisible();
  });

  it.failing("shows a pay day result when the form is submitted", async () => {
    const user = userEvent.setup();
    spyFetch.mockResolvedValueOnce(
      new Response(`{"payDate":"2026-10-30","paymentDate":"2026-10-26"}`),
    );

    render(<PaydayCalculator />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);

    await user.selectOptions(monthField, "1");
    await user.clear(yearField);
    await user.type(yearField, "2026");
    await user.click(submitButton);

    const payDateResult = screen.getByTestId(PaydayResultTestIds.payDate);
    const paymentDateResult = screen.getByTestId(
      PaydayResultTestIds.paymentDate,
    );
    expect(payDateResult).toHaveTextContent("Friday, 30/10/2026");
    expect(paymentDateResult).toHaveTextContent("Monday, 26/10/2026");
  });
});
