BINARY=bin/robotd
TARGET= $(BINARY)
LINK=g++
HOME=../
CINC=-I/usr/local/tlibc/include/ -I$(HOME)/common/include
LDPATH=-L/usr/local/tlibc/lib
DEPLIBS=-ltlibc
DEPOFILE=$(HOME)/common/lib/libcommon.a

CPPFILE=$(wildcard source/*.cpp)
DFILE=$(wildcard source/*.d)

include $(HOME)/build.mk

dep:
	@mkdir -p bin

install:
	mkdir -p $(PREFIX)
	cp -rf bin $(PREFIX)

