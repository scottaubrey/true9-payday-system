import { afterAll, beforeEach, describe, expect, it, spyOn } from "bun:test";
import { ApiClient } from "./api-client";

const spyFetch = spyOn(globalThis, "fetch");

describe("ApiClient", () => {
  beforeEach(() => {
    spyFetch.mockReset();
  });

  afterAll(() => {
    spyFetch.mockRestore();
  });

  describe("payday", () => {
    it("fetches from the API", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"payDate":"2026-10-30","paymentDate":"2026-10-26"}`),
      );

      await ApiClient.payday("2026", "10");
      expect(spyFetch).toHaveBeenCalled();
    });

    it("returns a success object for the payday view", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response('{"payDate":"2026-10-30","paymentDate":"2026-10-26"}'),
      );

      const response = await ApiClient.payday("2026", "10");

      if (!response.success) {
        expect().fail();
        return;
      }
      expect(response.data).toEqual({
        payDate: new Date("2026-10-30"),
        paymentDate: new Date("2026-10-26"),
      });
    });

    it("returns a error object when the api fails", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"message":"An error occurred"}`, {
          status: 400,
        }),
      );

      const response = await ApiClient.payday("2026", "10");

      if (response.success) {
        expect().fail();
        return;
      }

      expect(response.error).toBe("An error occurred");
    });

    it.todo("returns a error object when the data structure is incorrect");
  });
});
