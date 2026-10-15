import { describe, expect, it } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayFormTestIds } from "../components/PaydayForm";
import { PaydayCalculator } from "./PaydayCalculator";

describe("PaydayCalculator", () => {
  it("shows a pay day form", () => {
    render(<PaydayCalculator />);

    const paydayCalculatorForm = screen.getByTestId(PaydayFormTestIds.form);
    expect(paydayCalculatorForm).toBeVisible();
  });

  it.todo("shows a pay day result when the form is submitted");
});
