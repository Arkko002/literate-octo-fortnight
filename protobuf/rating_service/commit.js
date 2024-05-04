#!/usr/bin/env node
"use strict";

const util = require("util");
const exec = util.promisify(require("child_process").exec);
const spawn = require("child_process").spawnSync;
const fs = require("fs");

async function bumpNpmVersion(versionType) {
  const npmPackageCwd = "./src/ts/";

  const { stdout, stderr } = spawn(
    `npm version ${versionType} --no-git-tag-version`,
    { cwd: npmPackageCwd },
  );
  if (stderr) throw stderr;
  const npmVersion = stdout;

  spawn("git", ["add", "package.json", "package-lock.json"], {
    stdio: "inherit",
    cwd: npmPackageCwd,
  });
  spawn("git", ["commit", "-m", gitMessage.trim()], {
    stdio: "inherit",
    cwd: npmPackageCwd,
  });
  spawn("git", ["tag", npmVersion.trim()], {
    stdio: "inherit",
    cwd: npmPackageCwd,
  });
  spawn("git", ["status"], { stdio: "inherit", cwd: npmPackageCwd });

  const currentBranch = await branch();
  spawn("git", ["push", "origin", currentBranch.trim()], {
    stdio: "inherit",
    cwd: npmPackageCwd,
  });
}

// TODO:
// async function bumpComposerVersion(versionType) {
//   const composer_package_cwd = "./src/php/";
//   const { stdout, stderr } = await spawn(
//     `composer config minimum-stability dev`,
//     { cwd: composer_package_cwd },
//   );
//   if (stderr) throw stderr;
//   const composer_version = stdout;
//   await spawn("git", ["add", "composer.json", "composer.lock"], {
//     stdio: "inherit",
//   });
//   await spawn("git", ["commit", "-m", gitMessage.trim()], {
//     stdio: "inherit",
//   });
//   await spawn("git", ["tag", npmVersion.trim()], { stdio: "inherit" });
//   await spawn("git", ["status"], { stdio: "inherit" });
//   const currentBranch = await branch();
//   spawn("git", ["push", "origin", currentBranch.trim()], {
//     stdio: "inherit",
//   });
// }
async function addProtobufFilesToStaging() {
  const protoFiles = fs
    .readdirSync("./proto")
    .filter((file) => file.endsWith(".proto"));
  spawn("git", ["add", ...protoFiles], { stdio: "inherit" });
}

function generateCode() {
  const generate_code_cwd = "./";
  spawn("buf", ["generate"], {
    cwd: generate_code_cwd,
    stdio: "inherit",
  });
}

async function branch() {
  const { stdout, stderr } = await exec(`git rev-parse --abbrev-ref HEAD`);
  if (stderr) throw stderr;
  return stdout;
}

const run = async () => {
  try {
    const versionType = process.argv[2];
    const gitMessage = process.argv[3];

    if (
      versionType !== "patch" &&
      versionType !== "minor" &&
      versionType !== "major"
    )
      throw new Error("You need to specify npm version! [patch|minor|major]");
    if (!gitMessage)
      throw new Error("You need to provide a git commit message!");

    addProtobufFilesToStaging();
    generateCode();
    const npmVersion = await bumpNpmVersion(versionType);
    console.log(`NpmVersion: ${npmVersion}`);
  } catch (err) {
    console.log("Something went wrong:");
    console.error(JSON.stringify(err));
    console.error(
      '\nPlease use this format: \nnpm run commit [patch|minor|major] "Commit message"',
    );
  }
};

run();
