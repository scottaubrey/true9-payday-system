import { describe, expect, it } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayResult, PaydayResultTestIds } from "./PaydayResult";

describe("PaydayResult", () => {
  it("shows a pay and payment date in the expected format", () => {
    render(
      <PaydayResult
        payDate={new Date("2026-10-30")}
        paymentDate={new Date("2026-10-26")}
      />,
    );

    expect(screen.getByTestId(PaydayResultTestIds.payDate)).toHaveTextContent(
      "Friday, 30/10/2026",
    );
    expect(
      screen.getByTestId(PaydayResultTestIds.paymentDate),
    ).toHaveTextContent("Monday, 26/10/2026");
  });

  it("shows a pay and payment date with leading zero padding", () => {
    render(
      <PaydayResult
        payDate={new Date("2026-01-09")}
        paymentDate={new Date("2026-01-05")}
      />,
    );

    expect(screen.getByTestId(PaydayResultTestIds.payDate)).toHaveTextContent(
      "Friday, 09/01/2026",
    );
    expect(
      screen.getByTestId(PaydayResultTestIds.paymentDate),
    ).toHaveTextContent("Monday, 05/01/2026");
  });
});
