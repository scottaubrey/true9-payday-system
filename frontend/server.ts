import index from "./index.html";

const API_TARGET = "http://localhost:8888/";

// run and cleanup PHP API server
const phpServer = Bun.spawn(["mise", "start"], {
  stdout: "inherit",
  stderr: "inherit",
});
process.on("SIGINT", () => {
  phpServer.kill();
  process.exit(0);
});

const server = Bun.serve({
  routes: {
    "/": index,
    "/api/*": (req) => {
      const url = new URL(req.url);
      const targetUrl = `${API_TARGET}${url.pathname}${url.search}`;

      return fetch(targetUrl, req);
    },
  },
  development: true,
});

setTimeout(
  () => console.log(`Frontend server is running, visit ${server.url}`),
  1000,
);
